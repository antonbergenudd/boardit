<?php

namespace boardit\Console\Commands;

use Illuminate\Console\Command;
use boardit\RegisterCode;
use Illuminate\Support\Facades\Hash;

class GenerateRegisterCode extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boardit:generate-reg-code';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates a register code, valid for 10 minutes from creation';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {        
        $pass = str_random(15);

        dump('Passcode: ' . $pass);

        $hashedCode = Hash::make($pass);

        $obj = new RegisterCode;
        $obj->code = $hashedCode;
        $obj->save();
    }
}
