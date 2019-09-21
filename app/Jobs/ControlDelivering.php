<?php

namespace boardit\Jobs;

use boardit\User;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Carbon\Carbon;
use Twilio\Rest\Client;

class ControlDelivering implements ShouldQueue
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
        foreach(User::where('delivering', 1)->get() as $user) {
            if(Carbon::parse($user->delivering_since)->addHours('2') < Carbon::now()) {
                $accountSid = env('TWILIO_ACCOUNT_SID');
                $authToken = env('TWILIO_AUTH_TOKEN');

                $client = new Client($accountSid, $authToken);

                if($user->phone != 0) {
                    try {
                        $client->messages->create(
                            $employee->phone,
                            [
                                "body" => "2 timmar har gått sedan du började leverera, glöm inte att stänga av om du inte är tillgänglig längre!",
                                "from" => env('TWILIO_NUMBER')
                            ]
                        );

                        $user->delivering_since = Carbon::now();
                        $user->save();
                    } catch (TwilioException $e) {
                        echo  $e;
                    }
                }
            }
        }
    }
}
