<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use boardit\Order;
use boardit\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'code' => str_random(12),
        'user_id' => function () {
            return factory(User::class)->create()->id;
        },
        'address' => $faker->address,
        'payment' => 1,
        'payment_type' => 'kort',
    ];
});
