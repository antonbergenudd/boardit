<?php

namespace boardit\Console;

use boardit\Jobs\CloseDelivering;
use boardit\Jobs\ControlOrders;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

use boardit\Jobs\ControlDelivering;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        $schedule->job(new ControlDelivering)->everyFifteenMinutes();

        // Close website
        $schedule->job(new CloseDelivering)->dailyAt("20:00"); // Motsvarar 22 på svensk tid

        // Set corrupt orders
        $schedule->job(new CloseDelivering)->everyMinute();
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
