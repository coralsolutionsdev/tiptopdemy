<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Form\Response;
use Faker\Generator as Faker;

$factory->define(Response::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->text,
        'colors' => $faker->text,
        'angle' => $faker->randomNumber(),
        'structure' => $faker->text,
        'status' => $faker->,
        'position' => $faker->randomNumber(),
        'creator_id' => factory(\App\Modules\Form\Users.id::class),
        'editor_id' => factory(\App\Modules\Form\Users.id::class),
    ];
});
