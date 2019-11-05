<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use boardit\Order;
use boardit\User;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {

    return [
        'code' => str_random(12),
        'user_id' => function() {
            return factory(User::class)->create()->id;
        },
        'email' => $faker->email,
        'phone' => $faker->phoneNumber,
        'address' => $faker->address,
        'payment' => 1,
        'status' => Order::PROCESSING,
        'payment_type' => Order::PAYMENT_CARD,
        'payment_token' => str_random(12),
    ];
});
