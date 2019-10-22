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
        $accountSid = env('TWILIO_ACCOUNT_SID');
        $authToken = env('TWILIO_AUTH_TOKEN');
        $client = new Client($accountSid, $authToken);

        foreach(Order::whereNotNull('deliverance_date')->where('status', Order::CONFIRMED)->get() as $order) {

            // If within 4 - 3,8 hrs, notify employee
            if(
                Carbon::now()->addHours('4')->gte(Carbon::parse($order->deliverance_date))
                &&
                Carbon::now()->addHours('3')->addMinutes('40')->lt(Carbon::parse($order->deliverance_date))
            ) {
                $productsString = '';
                foreach($order->getProducts as $product) {
                    $productsString .= "\r\n{$product->name}";
                }

                // Notify user who confirmed about order
                $employee = User::where('user_id', $order->user_id)->first();
                $this->notifyEmployee($productsString, $order->address, $employee->phone);
            }
        }
    }

    private function notifyEmployee($products, $address, $phone) {
        try {
            $client->messages->create(
                $phone,
                [
                    "body" => "En order är schemalagd på dig inom 2 timmar!" .
                        "\r\nProdukter: " . $products .
                        "\r\nAdress: " . $address,
                    "from" => env('TWILIO_NUMBER')
                ]
            );
        } catch (TwilioException $e) {
            echo  $e;
        }
    }
}
