<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Course\Lesson;
use Faker\Generator as Faker;

$factory->define(Lesson::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->text,
        'type' => $faker->randomNumber(),
        'unit_id' => factory(\App\Modules\Course\Units.id::class),
        'status' => $faker->,
        'position' => $faker->randomNumber(),
        'creator_id' => factory(\App\Modules\Course\Users.id::class),
        'editor_id' => factory(\App\Modules\Course\Users.id::class),
    ];
});
