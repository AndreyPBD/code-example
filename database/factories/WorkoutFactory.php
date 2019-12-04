<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\Workout;
use Faker\Generator as Faker;

$factory->define(Workout::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'author_id' => $faker->word,
        'training_type_id' => $faker->word,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
