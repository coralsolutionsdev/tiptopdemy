<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Store\Invoice;
use Faker\Generator as Faker;

$factory->define(Invoice::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'order_id' => factory(\App\Modules\Store\Order::class),
        'order_number' => $faker->word,
        'date' => $faker->dateTime(),
        'date_paid' => $faker->dateTime(),
        'customer_name' => $faker->word,
        'customer_phone_number' => $faker->word,
        'billing_company_name' => $faker->word,
        'billing_address' => $faker->text,
        'billing_city' => $faker->word,
        'billing_state' => $faker->word,
        'billing_postcode' => $faker->numberBetween(-10000, 10000),
        'billing_country' => $faker->word,
        'description' => $faker->text,
        'status' => $faker->numberBetween(-8, 8),
        'type' => $faker->numberBetween(-10000, 10000),
        'currency' => $faker->word,
        'subtotal' => $faker->randomFloat(0, 0, 9999999999.),
        'grand_total' => $faker->randomFloat(0, 0, 9999999999.),
        'discount_type' => $faker->numberBetween(-10000, 10000),
        'discount_amount' => $faker->randomFloat(0, 0, 9999999999.),
        'taxes' => $faker->text,
        'payment_method' => $faker->numberBetween(-10000, 10000),
        'notes' => $faker->text,
    ];
});
