<?php

namespace boardit\Jobs;

use boardit\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;

class ControlOrders implements ShouldQueue
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
     * If order is either past 2 hours before delivered or past 24 hours and not returned
     *
     * @return void
     */
    public function handle()
    {
        foreach(Order::where('error', 0)->get() as $order) {
            if(
                Carbon::now('Europe/Stockholm')->addHours('2')->lt($order->confirmed_at) && $order->status <= Order::CONFIRMED
                ||
                Carbon::now('Europe/Stockholm')->addDays('1')->lt($order->delivered_at) && $order->status != Order::RETURNED
            ) {
                $order->error = 1;
                $order->save();
            }
        }
    }
}
