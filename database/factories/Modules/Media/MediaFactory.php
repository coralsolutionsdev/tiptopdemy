<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Modules\Media\MediaFile;
use Faker\Generator as Faker;

$factory->define(MediaFile::class, function (Faker $faker) {
    return [
        'title' => $faker->sentence(4),
        'type' => $faker->randomNumber(),
        'storage_type' => $faker->randomNumber(),
        'source' => $faker->word,
        'status' => $faker->,
        'position' => $faker->randomNumber(),
        'creator_id' => factory(\App\Modules\Media\Users.id::class),
        'editor_id' => factory(\App\Modules\Media\Users.id::class),
    ];
});
