<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Course\Unit;
use Faker\Generator as Faker;

$factory->define(Unit::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->text,
        'ancestor_id' => factory(\App\Modules\Course\Unit::class),
        'product_id' => factory(\App\Modules\Course\Products.id::class),
        'status' => $faker->,
        'position' => $faker->randomNumber(),
        'creator_id' => factory(\App\Modules\Course\Users.id::class),
        'editor_id' => factory(\App\Modules\Course\Users.id::class),
    ];
});
