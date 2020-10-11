<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Form\FormResponse;
use Faker\Generator as Faker;

$factory->define(FormResponse::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'hash_id' => $faker->word,
        'form_id' => factory(\App\Modules\Form\Form::class),
        'ancestor_id' => factory(\App\Modules\Form\Form::class),
        'responer_info' => $faker->text,
        'data' => $faker->text,
        'status' => $faker->numberBetween(-8, 8),
        'type' => $faker->numberBetween(-10000, 10000),
        'notes' => $faker->text,
        'creator_id' => factory(\App\Modules\Form\User::class),
        'editor_id' => factory(\App\Modules\Form\User::class),
    ];
});
