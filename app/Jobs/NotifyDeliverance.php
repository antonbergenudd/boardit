<?php

namespace boardit\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

use Carbon\Carbon;
use Twilio\Rest\Client;
use boardit\Order;
use boardit\User;

class NotifyDeliverance implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Notify drivers about a scheduled order 1,5 - 2 hrs
     * prio to deliverance date.
     *
     * @return void
     */
    public function handle()
    {
        foreach(Order::whereNotNull('deliverance_date')->where('status', Order::CONFIRMED)->get() as $order) {
            if(
                Carbon::now('Europe/Stockholm')->addHours('2')->gte($order->deliverance_date)
                &&
                Carbon::now('Europe/Stockholm')->addHours('1')->addMinutes('40')->lt($order->deliverance_date)
            ) {
                $productsString = '';
                foreach($order->getProducts as $product) {
                    $productsString .= "\r\n{$product->name}";
                }

                // Notify user who confirmed about order
                $employee = User::find($order->user_id);
                $this->notifyEmployee($productsString, $order->address, $employee->phone);
            }
        }
    }

    private function notifyEmployee($products, $address, $phone) {
        if(env('TWILIO_TEST')) {
            $accountSid = env('TWILIO_ACCOUNT_SID_TEST');
            $authToken = env('TWILIO_AUTH_TOKEN_TEST');
        } else {
            $accountSid = env('TWILIO_ACCOUNT_SID');
            $authToken = env('TWILIO_AUTH_TOKEN');
        }

        $client = new Client($accountSid, $authToken);

        if(substr($phone, 0, 1) == '0') {
            $phone = substr_replace($phone, '+46', 0, 1);
        }

        try {
            $client->messages->create(
                $phone,
                [
                    "body" => "En order är schemalagd på dig inom 2 timmar!" .
                        "\r\nProdukter: " . $products .
                        "\r\nAdress: " . $address,
                    "from" => env('TWILIO_TEST') ? env('TWILIO_NUMBER_TEST') : env('TWILIO_NUMBER')
                ]
            );
        } catch (TwilioException $e) {
            echo  $e;
        }
    }
}
