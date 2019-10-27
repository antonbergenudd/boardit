<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use boardit\Product;
use Faker\Generator as Faker;

$factory->define(Product::class, function (Faker $faker) {
    return [
        'name' => $faker->name,
        'description' => $faker->text,
        'price' => $faker->randomNumber(),
        'quantity' => 0,
        'thumbnail' => $faker->image()
    ];
});
