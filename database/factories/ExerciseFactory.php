<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Models\DifficultyLevel;
use App\Models\Exercise;
use App\Models\ExerciseBiomechanics;
use App\Models\ExerciseForceVector;
use App\Models\Muscle;
use App\Models\TrainingType;
use Faker\Generator as Faker;

$factory->define(Exercise::class, function (Faker $faker) {

    return [
        'name' => $faker->word,
        'author_id' =>  DB::table('users')->where(['name' => 'admin'])->value('id'),
        'difficulty_level_id' => factory(DifficultyLevel::class)->create()->id,
        'training_type_id' => factory(TrainingType::class)->create()->id,
        'muscle_id' => factory(Muscle::class)->create()->id,
        'is_active' => rand(true, false),
        'positive_phase' => [
            'duration' => rand(1, 20),
            'breath' => array_rand([Exercise::BREATH_OUT => '', Exercise::BREATH_IN => ''])
        ],
        'negative_phase' => [
            'duration' => rand(1, 20),
            'breath' => array_rand([Exercise::BREATH_OUT => '', Exercise::BREATH_IN => ''])
        ],
        'exercise_biomechanics_id' => factory(ExerciseBiomechanics::class)->create()->id,
        'exercise_force_vector_id' => factory(ExerciseForceVector::class)->create()->id,
        'is_side_changing' => rand(true, false),
        'technique' => $faker->text,
        'warning' => $faker->text,
        'short_advice' => $faker->text,
        'created_at' => $faker->date('Y-m-d H:i:s'),
        'updated_at' => $faker->date('Y-m-d H:i:s')
    ];
});
