<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\System\TodoItem;
use Faker\Generator as Faker;

$factory->define(TodoItem::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'description' => $faker->text,
        'status' => $faker->numberBetween(-8, 8),
        'type' => $faker->numberBetween(-10000, 10000),
        'priority' => $faker->numberBetween(-10000, 10000),
        'creator_id' => factory(\App\Modules\System\User::class),
        'editor_id' => factory(\App\Modules\System\User::class),
    ];
});
