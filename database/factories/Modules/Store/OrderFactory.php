<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Store\Order;
use Faker\Generator as Faker;

$factory->define(Order::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'order_number' => $faker->word,
        'description' => $faker->text,
        'status' => $faker->numberBetween(-8, 8),
        'type' => $faker->numberBetween(-10000, 10000),
        'currency' => $faker->word,
        'subtotal' => $faker->randomFloat(0, 0, 9999999999.),
        'grand_total' => $faker->randomFloat(0, 0, 9999999999.),
        'discount_type' => $faker->numberBetween(-10000, 10000),
        'discount_amount' => $faker->randomFloat(0, 0, 9999999999.),
        'taxes' => $faker->text,
        'customer_name' => $faker->word,
        'customer_phone_number' => $faker->word,
        'billing_company_name' => $faker->word,
        'billing_address' => $faker->text,
        'billing_city' => $faker->word,
        'billing_state' => $faker->word,
        'billing_postcode' => $faker->numberBetween(-10000, 10000),
        'billing_country' => $faker->word,
        'shipping_company_name' => $faker->word,
        'shipping_address' => $faker->word,
        'shipping_city' => $faker->word,
        'shipping_state' => $faker->word,
        'shipping_postcode' => $faker->numberBetween(-10000, 10000),
        'shipping_country' => $faker->word,
        'notes' => $faker->text,
        'creator_id' => factory(\App\Modules\Store\User::class),
        'editor_id' => factory(\App\Modules\Store\User::class),
    ];
});
