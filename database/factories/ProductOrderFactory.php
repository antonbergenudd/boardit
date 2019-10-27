<?php

/* @var $factory \Illuminate\Database\Eloquent\Factory */

use boardit\Product;
use boardit\Order;
use boardit\ProductOrder;
use Faker\Generator as Faker;

$factory->define(ProductOrder::class, function (Faker $faker) {
    return [
        'order_id' => function () {
            return factory(Order::class)->create()->id;
        },
        'product_id' => function () {
            return factory(Product::class)->create()->id;
        },
    ];
});
