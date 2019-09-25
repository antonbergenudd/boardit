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
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        // If order is either past 2 hours before delivered or past 24 hours and not returned
        foreach(Order::where('error', 0)->get() as $order) {
            if(
                $order->status == Order::CONFIRMED && Carbon::parse($order->confirmed_at)->addHours('2') < Carbon::now()
                || $order->status == Order::DELIVERED && Carbon::parse($order->delivered_at)->addDays('1') < Carbon::now()
            ) {
                $order->error = 1;
                $order->save();
            }
        }
    }
}
