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
use boardit\ProductOrder;
use boardit\Product;

class CheckScheduledProducts implements ShouldQueue
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
     * Reserve product if scheduled within the coming 25 hours
     *
     * @return void
     */
    public function handle()
    {
        foreach(Order::where('status', Order::CONFIRMED)->get() as $order) {
            if(Carbon::now()->addDays('1')->addHours('2')->gte(Carbon::parse($order->deliverance_date))) {
                foreach($order->getProducts as $product) {
                    // Random product
                    if($product->id == 14) {
                        $items = Product::where('quantity', '>=', 0)->get();

                        do {
                            $item_id = array_rand($items->toArray());
                        } while($item_id == 14);

                        $product = $items[$item_id];
                    }

                    // Remove item from DB
                    if($product->quantity) {
                        $product->quantity--;
                    }

                    $product->save();
                }

                $order->status = Order::CONFIRMED_AND_RESERVED;
                $order->save();
            }
        }
    }
}
