<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Form\Form;
use Faker\Generator as Faker;

$factory->define(Form::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->text,
        'version' => $faker->randomNumber(),
        'master_id' => factory(\App\Modules\Form\Form::class),
        'ancestor_id' => factory(\App\Modules\Form\Form::class),
        'submit_route' => $faker->text,
        'type' => $faker->randomNumber(),
        'status' => $faker->,
        'position' => $faker->randomNumber(),
        'structure' => $faker->text,
        'creator_id' => factory(\App\Modules\Form\Users.id::class),
        'editor_id' => factory(\App\Modules\Form\Users.id::class),
        'start_at' => $faker->dateTime(),
        'expire_at' => $faker->dateTime(),
    ];
});
