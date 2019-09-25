<?php

namespace boardit\Http\Controllers;

use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Mail;

use boardit\ProductOrder;
use boardit\User;
use boardit\Order;

use Carbon\Carbon;

use Twilio\Exceptions\TwilioException;
use Twilio\Rest\Client;

use boardit\Mail\ConfirmationMailable;

class OrderController extends BaseController
{
    public function index() {
        $orders = Order::all();
        
        return view('auth.orders', compact('orders'));
    }

    public function confirm(User $user, Order $order, $redirect = true) {
        $order->status = Order::CONFIRMED;
        $order->confirmed_at = Carbon::now();
        $order->delivered_at = NULL;
        $order->user_id = $user->id;
        $order->save();

        try {
            $this->notifyThroughSms($order);
        } catch (TwilioException $e) {
            echo  $e;
        }

        $this->email($order);

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
        $order->delivered_at = NULL;

        $order->save();

        return back();
    }

    public function deliver(User $user, Order $order) {
        $order->status = Order::DELIVERED;
        $order->delivered_at = Carbon::now();
        $order->confirmed_at = NULL;
        $order->error = 0;

        $order->save();

        return back();
    }

    private function notifyThroughSms($order)
    {
        $this->sendSms(
            $order->phone,
            "Din order är bekräftad!" .
            "\r\nReferenskod: " . $order->code .
            "\r\nVäntad leveranstid ". Carbon::now('Europe/Stockholm')->addHours('2')->format('H:i') .
            "\r\nMvh, Boarditgames.\r\nTack för att ni valde oss!"
        );
    }

    private function sendSms($to, $message)
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
            if(!$order->confirmed) {
                $body = 'Du har accepterat uppdraget.';

                $nr = str_replace("+46", "0", $to);
                $user = User::where('phone', $nr)->first();

                $this->confirm($user, $order, false);
            } else {
                $body = 'Uppdraget är redan taget.';
            }

            $sendDefault = false;
        }

        // Send the correct response message.
        $client->messages->create(
            $to,
            array(
                'from' => $from,
                'body' => $sendDefault ? $defaultMessage : $body,
            )
        );
    }
}
