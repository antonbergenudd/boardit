<?php

namespace boardit\Http\Controllers;

use boardit\DiscountCode;
use boardit\ProductOrder;
use boardit\Http\Requests\PaymentSubmitRequest;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Http\Request;

use boardit\Product;
use boardit\User;

use boardit\Order;

use Stripe\Charge;
use Stripe\Stripe;

use Twilio\Rest\Client;
use Gloudemans\Shoppingcart\Facades\Cart;

// https://github.com/Crinsane/LaravelShoppingcart#usage
// https://github.com/stripe/stripe-php
class PaymentController extends BaseController
{
    function index() {
        $cart = Cart::content();
        $cartTotal = Cart::subtotal();

        return view('payment.index', compact('cart', 'cartTotal'));
    }

    function feedback() {
        return view('payment.feedback');
    }

    function checkDiscount($discount_code, $total) {
        if($discount_code) {
            $code = DiscountCode::where('code', $discount_code)->first();

            if(isset($code)) {
                $total = $total * ($code->amount / 100);
            }
        }

        return $total;
    }

    function controlDiscount(Request $request) {
        $code = $request->code;

        if($code) {
            $code = DiscountCode::where('code', $code)->first();

            if(isset($code)) {
                return $code->amount;
            }
        }

        return null;
    }

    function removeDiscountCode($discount_code) {
        $code = DiscountCode::where('code', $discount_code)->first();
        $code->delete();
    }

    function submit(PaymentSubmitRequest $request) {

        if(env('STRIPE_TEST_MODE')) {
            Stripe::setApiKey(env('STRIPE_TEST_KEY'));
        } else {
            Stripe::setApiKey(env('STRIPE_PROD_KEY'));
        }

        // Generate code and save payment to database
        $code = str_random(12);
        $order = new Order;

        $payment_ok = 0;
        if(strtolower($request->city) == 'lund') {

            foreach(Cart::content() as $product) {
                if($product->id == 15) {
                    $order->collect = 1;
                }

                if($product->id == 16) {
                    $order->deliver = 1;
                }
            }

            $total = str_replace(".00", "", Cart::subTotal() + 30); // Addon för utkörning

            if(isset($request->payment_by_swish)) {
                // $order->code = $code;
                // $order->address = $request->street.', '.$request->postcode.', '.$request->city;
                // $order->email = isset($request->email) ? $request->email : NULL;
                // $order->phone = isset($request->tel) ? $request->tel : NULL;
                // $order->payment = $this->checkDiscount($request->discount_code, $total);
                // $order->payment_type = 'swish';
                // $order->note = $request->note;
                // $order->save();
                //
                // $payment_ok = 1;
            } else if(isset($request->payment_by_card)) {
                $charge = Charge::create([
                    'amount' => $this->checkDiscount($request->discount_code, $total) * 100,
                    'currency' => 'sek',
                    'description' => 'Beställning av spel',
                    'source' => $request->stripeToken,
                    'receipt_email' => $request->email,
                ]);

                if($charge->status == 'succeeded') {
                    $order->code = $code;
                    $order->address = $request->street.', '.$request->postcode.', '.$request->city;
                    $order->email = isset($request->email) ? $request->email : NULL;
                    $order->phone = isset($request->tel) ? $request->tel : NULL;
                    $order->payment = $this->checkDiscount($request->discount_code, $total); // Addon för utkörning
                    $order->payment_type = 'card';
                    $order->note = $request->note;
                    $order->save();

                    $payment_ok = 1;
                }
            }

            if($payment_ok) {
                foreach(Cart::content() as $row) {
                    $product = $row->model;
                    $orderToProduct = new ProductOrder;

                    // Random product
                    if($product->id == 14) {
                        $items = Product::where('quantity', '>=', 0)->get();

                        do {
                            $item_id = array_rand($items->toArray());
                        } while($item_id == 14);

                        $product = $items[$item_id];
                    }

                    $orderToProduct->product_id = $product->id;
                    $orderToProduct->order_id = $order->id;

                    // Remove item from DB
                    if($product->quantity) {
                        $product->quantity--;
                    }

                    $product->save();

                    $orderToProduct->save();
                }

                $this->notifyThroughSms($order);

                if($request->discount_code) {
                    $this->removeDiscountCode($request->discount_code);
                }

                Cart::destroy();

                return view('payment.feedback', compact('code'));
            } else {
                return view('payment.feedback')->withErrors([
                    'Det gick fel vid betalningen.'
                ]);
            }
        } else {
            return view('payment.feedback')->withErrors([
                'Tyvärr kör vi inte ut till din stad just nu, oroa dig inte, ingen betalning har utförts.'
            ]);
        }
    }

    private function notifyThroughSms($order)
    {
        if(env('SEND_SMS')) {
            $this->sendSms(
                "En order har skapats!" .
                "\r\nReferenskod: " . $order->code .
                "\r\nAdress: " . $order->address .
                "\r\nSvara med JA för att bekräfta order"
            );
        }
    }

    protected function sendSms($message)
    {
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');

        $client = new Client($accountSid, $authToken);

        foreach(User::where('delivering', 1)->get() as $employee) {
            if($employee->phone != 0) {
                try {
                    $client->messages->create(
                        $employee->phone,
                        [
                            "body" => $message,
                            "from" => env('TWILIO_NUMBER')
                        ]
                    );
                } catch (TwilioException $e) {
                    echo  $e;
                }
            }
        }
    }
}
