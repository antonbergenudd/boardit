<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

use boardit\ProductOrder;
use boardit\User;
use boardit\Order;
use boardit\DiscountCode;
use boardit\Mail\ConfirmationMailable;

use Illuminate\Http\Request;

use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use Gloudemans\Shoppingcart\Facades\Cart;

use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

class OrderController extends BaseController
{
    public function index() {
        $orders = Order::all();

        return view('auth.orders', compact('orders'));
    }

    public function status(Order $order) {
        return $order->status == Order::CONFIRMED || $order->status == Order::CONFIRMED_AND_RESERVED ? "true" : "false";
    }

    public function quantity($cart_product_id) {
        $item = Cart::search(function($cartItem, $rowId) use ($cart_product_id) {
            return $cartItem->id == $cart_product_id;
        })->first();
        
        return $item->model->quantity;
    }

    public function setFailed(Order $order) {
        $order->status = Order::FAILED;
        $order->error = 1;

        // Add item back to stock if outside of timeframe
        foreach($order->getProducts as $product) {
            $product->quantity++;
            $product->save();
        }

        $order->save();
    }

    public function notifyOffline(Order $order) {
        if(env('TWILIO_TEST')) {
            $accountSid = env('TWILIO_ACCOUNT_SID_TEST');
            $authToken = env('TWILIO_AUTH_TOKEN_TEST');
        } else {
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
        }

        $client = new Client($accountSid, $authToken);

        foreach(User::where('delivering', 0)->where('phone', '!=', 0)->get() as $employee) {
            if(Carbon::now()->addHours('4')->gt($order->deliverance_date)) {
                $productsString = '';
                foreach($order->getProducts as $product) {
                    $productsString .= "\r\n{$product->name}";
                }

                $message = "En order har skapats!" .
                    "\r\nSnabbt ärende." .
                    "\r\nLevereras inom 2 timmar från svar." .
                    "\r\nReferenskod: " . $order->code .
                    "\r\nProdukter: " .$productsString .
                    "\r\nAdress: " . $order->address .
                    "\r\nSvara JA för att bekräfta order.";
            } else {
                $message = "En order har skapats!" .
                    "\r\nFramtida ärende." .
                    "\r\nReferenskod: " . $order->code .
                    "\r\nDatum: " . $order->deliverance_date .
                    "\r\nHar du möjlighet att leverera beställningen vid detta datum?" .
                    "\r\nSvara JA för att bekräfta beställning.";
            }

            try {
                $phone = $employee->phone;

                if(substr($phone, 0, 1) == '0') {
                    $phone = substr_replace($phone, '+46', 0, 1);
                }

                $client->messages->create(
                    $phone,
                    [
                        "body" => $message,
                        "from" => env('TWILIO_TEST') ? env('TWILIO_NUMBER_TEST') : env('TWILIO_NUMBER')
                    ]
                );
            } catch (TwilioException $e) {
                echo  $e;
            }
        }
    }

    private function checkDiscount($discount_code, $total) {
        $code = DiscountCode::where('code', $discount_code)->first();

        if(isset($code)) {
            $total = $total * (1 - ($code->amount / 100));

            if(! $code->repeatable) {
                $code->delete();
            }
        }

        return $total;
    }

    public function confirm(User $user, Order $order, $redirect = true) {
        if(env('STRIPE_TEST_MODE')) {
            Stripe::setApiKey(env('STRIPE_TEST_KEY'));
        } else {
            Stripe::setApiKey(env('STRIPE_PROD_KEY'));
        }

        if(isset($order->discount_code)) {
            $payment = $this->checkDiscount($order->discount_code, $order->payment);
        } else {
            $payment = $order->payment;
        }

        $charge = Charge::create([
            'amount' => $payment * 100,
            'currency' => 'sek',
            'description' => 'Beställning av spel',
            'customer' => $order->payment_token,
        ]);

        if($charge->status == 'succeeded') {
            $order->status = Order::CONFIRMED;

            $order->confirmed_at = Carbon::now();
            $order->user_id = $user->id;

            // Set product as reserved if outside of 2 hours and inside of 25 hrs
            if(
                Carbon::now('Europe/Stockholm')->addHours('2')->lt($order->deliverance_date)
                &&
                Carbon::now('Europe/Stockholm')->addDays('1')->gte($order->deliverance_date)
            ) {
                $order->status = Order::CONFIRMED_AND_RESERVED;
            } else if(Carbon::now('Europe/Stockholm')->addDays('1')->addHours('1')->lt($order->deliverance_date)) {
                foreach($order->getProducts as $product) {
                    $product->quantity++;
                    $product->save();
                }
            }

            // Text confirmation to customer
            try {
                $this->notifyCustomerThroughSms($order);
            } catch (TwilioException $e) {
                echo  $e;
            }
        } else {
            $order->status = Order::PAYMENT_FAILED;
        }

        $order->save();

        if($redirect) {
            return back();
        }
    }

    public function return(User $user, Order $order) {
        $relationships = ProductOrder::where('order_id', $order->id)->get();

        foreach($relationships as $relation) {
            $relation->product->quantity++;
            $relation->product->save();
        }

        $order->status = Order::RETURNED;
        $order->error = 0;

        $order->save();

        return back();
    }

    public function deliver(User $user, Order $order) {
        $order->status = Order::DELIVERED;
        $order->delivered_at = Carbon::now();
        $order->error = 0;

        $order->save();

        return back();
    }

    private function notifyCustomerThroughSms($order)
    {
        if(env('TWILIO_TEST')) {
            $accountSid = env('TWILIO_ACCOUNT_SID_TEST');
            $authToken = env('TWILIO_AUTH_TOKEN_TEST');
        } else {
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
        }

        $client = new Client($accountSid, $authToken);

        $phone = $order->phone;

        if(substr($phone, 0, 1) == '0') {
            $phone = substr_replace($phone, '+46', 0, 1);
        }

        try {
            $client->messages->create(
                $phone,
                [
                    "body" => "Din order är bekräftad!" .
                        "\r\nReferenskod: " . $order->code .
                        "\r\nVäntad leveranstid ". $order->deliverance_date .
                        "\r\nMvh, Boarditgames.\r\nTack för att ni handlade hos oss!",
                    "from" => env('TWILIO_TEST') ? env('TWILIO_NUMBER_TEST') : env('TWILIO_NUMBER')
                ]
            );
        } catch (TwilioException $e) {
            echo  $e;
        }
    }

    private function email($data) {
        try {
            Mail::to($data->email)
                ->send(new ConfirmationMailable($data));
        } catch(\Exception $e) {
            dd($e);
        }
    }

    public function receiveSms()
    {
        if(env('TWILIO_TEST')) {
            $accountSid = env('TWILIO_ACCOUNT_SID_TEST');
            $authToken = env('TWILIO_AUTH_TOKEN_TEST');
        } else {
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
        }

        $client = new Client($accountSid, $authToken);

        /*
        ** Default response message when receiving a message without key words.
        */
        $defaultMessage = "Svara JA om du vill acceptera uppdraget.";

        /*
        ** Read the contents of the incoming message fields.
        */
        $body = $_REQUEST['Body'];
        $to = env('TWILIO_TEST') ? '+46708605003' : $_REQUEST['From'];

        /*
        ** Remove formatting from $body until it is just lowercase
        ** characters without punctuation or spaces.
        */
        $response = preg_replace("/[^A-Za-z0-9]/u", " ", $body);
        $response = trim($response);
        $response = strtolower($response);
        $sendDefault = true; // Default message is sent unless key word is found in following loop.

        /*
        ** Choose the correct message response and set default to false.
        */
        if ($response == 'ja') {

            // Retrieve old messages to get last sent code
            $messages = $client->messages->read(array(), 20);
            foreach ($messages as $i => $record) {
                if(strpos($record->body, 'Referenskod') !== false) {
                    preg_match('/Referenskod:\s[0-9a-zA-Z]*/', $record->body, $matches);
                    $code = explode("Referenskod: ", $matches[0])[1];
                    break;
                }
            }

            // Retrieve order from DB
            $order = Order::where('code', $code)->first();

            // Check if already confirmed
            if(! isset($order->confirmed_at)) {
                $user = User::where('phone', str_replace("+46", "0", $to))->first();

                $this->confirm($user, $order, false);

                $body = 'Du har accepterat uppdraget.';
            } else {
                $body = 'Uppdraget är redan taget.';
            }

            $sendDefault = false;
        }

        // Send the correct response message.
        $client->messages->create(
            $to,
            array(
                'from' => env('TWILIO_TEST') ? env('TWILIO_NUMBER_TEST') : $_REQUEST['To'],
                'body' => $sendDefault ? $defaultMessage : $body,
            )
        );
    }
}
