<?php

namespace boardit\Http\Controllers;

use boardit\ProductOrder;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use boardit\Product;
use boardit\Order;
use boardit\User;
use boardit\Mail\ConfirmationMailable;
use Cart;
use Carbon\Carbon;

use Illuminate\Support\Facades\Log;

use Twilio\Rest\Client;

class MainController extends BaseController
{
    function index() {
        $products = Product::where('popular', 1)->get();

        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('index', compact('products', 'cart', 'cartTotal'));
    }

    function about() {
        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('about', compact('cart', 'cartTotal'));
    }

    function faq() {
        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('faq', compact('cart', 'cartTotal'));
    }

    function policy() {
        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('policy', compact('cart', 'cartTotal'));
    }

    function games() {
        $products = Product::where('show', 1)->get();

        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('games', compact('products', 'cart', 'cartTotal'));
    }

    public function orders() {
        $orders = Order::all();
        return view('auth.orders', compact('orders'));
    }

    public function confirmOrder(User $user, Order $order) {
        $order->confirmed = 1;
        $order->user_id = $user->id;
        $order->save();

        $this->notifyThroughSms($order);

        $this->email($order);

        return back();
    }

    public function returnOrder(User $user, Order $order) {
        $relationships = ProductOrder::where('order_id', $order->id)->get();

        foreach($relationships as $relation) {
            $relation->product->quantity++;
            $relation->product->save();
        }

        $order->returned = 1;
        $order->save();

        return back();
    }

    public function delivering(User $user, Request $request) {
        $user->delivering = $request->delivering;
        $user->save();

        return back();
    }

    private function email($data) {
        try {
            Mail::to($data->email)
                ->send(new ConfirmationMailable($data));
        } catch(\Exception $e) {
            dd($e);
        }
    }

    private function notifyThroughSms($order)
    {
        $this->sendSms(
            $order->phone,
            'Din order är bekräftad!' .
            ' Referenskod: ' . $order->code .
            ' Väntad leveranstid ' . Carbon::now('Europe/Stockholm')->addHours('1')->format('H:i') .
            ' Mvh, Boarditgames. Tack för att ni hantlade hos oss!'
        );
    }

    protected function sendSms($to, $message)
    {
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');

        $client = new Client($accountSid, $authToken);

        try {
            $client->messages->create(
                $to,
                [
                    "body" => $message,
                    "from" => env('TWILIO_NUMBER')
                ]
            );
        } catch (TwilioException $e) {
            echo  $e;
        }
    }

    public function receiveSms()
    {
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');

        $client = new Client($accountSid, $authToken);

        /*
        ** Default response message when receiving a message without key words.
        */
        $defaultMessage = "Svara JA om du vill acceptera uppdraget.";

        /*
        ** Read the contents of the incoming message fields.
        */
        $body = $_REQUEST['Body'];
        $to = $_REQUEST['From'];
        $from = $_REQUEST['To'];

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
            $body = 'Du har accepterat uppdraget.';

            $nr = str_replace("+46", "0", $to);
            $user = User::where('phone', $nr)->first();

            $messages = $client->messages->read(array(), 20);
            foreach ($messages as $i => $record) {
                if(strpos($record->body, 'Referenskod') !== false) {
                    Log::warning($record->body);
                    preg_match('/Referenskod:\s[0-9a-zA-Z]*/', $record->body, $matches);
                    Log::warning($matches);
                    $code = explode("Referenskod: ", $matches[0])[1];
                    break;
                }
            }

            Log::warning($code);
            $order = Order::where('code', $code)->first();

            $this->confirmOrder($user, $order);

            $sendDefault = false;
        }

        // Send the correct response message.
        if ($sendDefault != false) {
            $client->messages->create(
                $to,
                array(
                    'from' => $from,
                    'body' => $defaultMessage,
                )
            );
        } else {
            $client->messages->create(
                $to,
                array(
                    'from' => $from,
                    'body' => $body,
                )
            );
        }
    }
}
