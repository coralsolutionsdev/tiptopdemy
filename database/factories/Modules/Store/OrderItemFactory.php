<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Store\OrderItem;
use Faker\Generator as Faker;

$factory->define(OrderItem::class, function (Faker $faker) {
    return [
        'order_id' => factory(\App\Modules\Store\Order::class),
        'product_id' => factory(\App\Modules\Store\Product::class),
        'quantity' => $faker->numberBetween(-10000, 10000),
        'unit_price' => $faker->randomFloat(0, 0, 9999999999.),
        'total_price' => $faker->randomFloat(0, 0, 9999999999.),
        'notes' => $faker->text,
        'status' => $faker->numberBetween(-8, 8),
        'creator_id' => factory(\App\Modules\Store\User::class),
        'editor_id' => factory(\App\Modules\Store\User::class),
    ];
});
