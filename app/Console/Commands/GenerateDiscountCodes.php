<?php

namespace boardit\Console\Commands;

use boardit\DiscountCode;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class GenerateDiscountCodes extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'boardit:generate-discount-codes {amount : how many codes do you want to generate} {value? : discount in percentage}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generates an amount of discount codes';

    /**
     * Create a new command instance.
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
        $allDiscounts = DiscountCode::all();

        $existingCodes = $allDiscounts->map(function ($discount) {
            return collect($discount->toArray())
                ->only(['code'])
                ->all();
        })->toArray();

        for($i = 0; $i < $this->argument('amount'); $i++) {
            do {
                $pass = str_random(15);
            } while (in_array($pass, $existingCodes));

            $obj = new DiscountCode;
            $obj->code = $pass;
            $obj->amount = $this->argument('value') ? $this->argument('value') : 20;
            $obj->save();
        }

        dump($this->argument('amount') . ' discounts generated');
    }
}
