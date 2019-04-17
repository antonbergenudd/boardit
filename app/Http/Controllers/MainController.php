<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;
use boardit\Product;
use boardit\Order;
use boardit\Mail\ConfirmationMailable;
use Cart;
use Carbon\Carbon;

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
        $products = Product::all();

        $cart = Cart::content();
        $cartTotal = Cart::subTotal();

        return view('games', compact('products', 'cart', 'cartTotal'));
    }

    public function orders() {
        $orders = Order::all();
        return view('auth.orders', compact('orders'));
    }

    public function confirmOrder(Order $order) {
        $order->confirmed = 1;
        $order->save();

        //$this->notifyThroughSms($order);

        $this->email($order);

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
}
