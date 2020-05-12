<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\ColorPattern\ColorPattern;
use Faker\Generator as Faker;

$factory->define(ColorPattern::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->text,
        'colors' => $faker->text,
        'angle' => $faker->randomNumber(),
        'status' => $faker->,
        'position' => $faker->randomNumber(),
        'creator_id' => factory(\App\Modules\ColorPattern\Users.id::class),
        'editor_id' => factory(\App\Modules\ColorPattern\Users.id::class),
    ];
});
