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
        Log::warning($_REQUEST);

        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');

        $client = new Client($accountSid, $authToken);

        /*
        ** Array of response messages, to represent the function of a database.
        */
        $responseMessages = array(
            'monkey'    => array('body' => 'Monkey. A small to medium-sized primate that typically has a long tail, most kinds of which live in trees in tropical countries.',
                                 'media' => 'https://cdn.pixabay.com/photo/2016/02/12/23/49/scented-monkey-1197100_960_720.jpg'),
            'dog'       => array('body' => 'Dog. A domesticated carnivorous mammal that typically has a long snout, an acute sense of smell, and a barking, howling, or whining voice.',
                                 'media' => 'https://cdn.pixabay.com/photo/2016/10/15/12/01/dog-1742295_960_720.jpg'),
            'pigeon'   => array('body' => 'Pigeon. A stout seed- or fruit-eating bird with a small head, short legs, and a cooing voice, typically having gray and white plumage.',
                                 'media' => 'https://cdn.pixabay.com/photo/2016/11/17/21/12/pigeon-1832742_960_720.jpg'),
            'owl'       => array('body' => 'Owl. A nocturnal bird of prey with large forward-facing eyes surrounded by facial disks, a hooked beak, and typically a loud call.',
                                 'media' => 'https://cdn.pixabay.com/photo/2013/02/04/20/48/owl-77894_960_720.jpg')
        );

        /*
        ** Default response message when receiving a message without key words.
        */
        $defaultMessage = "Reply with one of the following keywords: monkey, dog, pigeon, owl.";

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
        $result = preg_replace("/[^A-Za-z0-9]/u", " ", $body);
        $result = trim($result);
        $result = strtolower($result);
        $sendDefault = true; // Default message is sent unless key word is found in following loop.

        /*
        ** Choose the correct message response and set default to false.
        */
        foreach ($responseMessages as $animal => $messages) {
            Log::warning($animal);
            Log::warning($messages);
            if ($animal == $result) {
                $body = $messages['body'];
                $media = $messages['media'];
                $sendDefault = false;
            }
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
                    // 'mediaUrl' => $media,
                )
            );
        }
    }
}
