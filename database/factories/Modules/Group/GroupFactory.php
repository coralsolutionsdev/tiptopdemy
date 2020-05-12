<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Group\Group;
use Faker\Generator as Faker;

$factory->define(Group::class, function (Faker $faker) {
    return [
        'hash_id' => $faker->word,
        'title' => $faker->sentence(4),
        'slug' => $faker->slug,
        'description' => $faker->text,
        'ancestor_id' => factory(\App\Modules\Group\Lists.id::class),
        'position' => $faker->randomNumber(),
        'type' => $faker->randomNumber(),
        'owner_type' => $faker->word,
        'owner_id' => factory(\App\Modules\Group\Owner::class),
        'color_id' => factory(\App\Modules\Group\ColorPatterns.id::class),
        'status' => $faker->,
        'creator_id' => factory(\App\Modules\Group\Users.id::class),
        'editor_id' => factory(\App\Modules\Group\Users.id::class),
    ];
});
