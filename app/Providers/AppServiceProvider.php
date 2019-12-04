<?php

namespace App\Providers;

use App\Models\BodyPart;
use App\Models\Country;
use App\Models\DifficultyLevel;
use App\Models\Equipment;
use App\Models\EquipmentKind;
use App\Models\EquipmentType;
use App\Models\Exercise;
use App\Models\ExerciseBiomechanics;
use App\Models\ExerciseForceVector;
use App\Models\Muscle;
use App\Models\MuscleGroup;
use App\Models\TrainingPack;
use App\Models\TrainingType;
use App\Models\User;
use App\Models\Workout;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(['muscle_groups.*', 'body_parts'], function ($view) {
             $view->with('bodyParts', BodyPart::pluck('name', 'id'));
        });

        View::composer(['muscles.*', 'muscle_groups'], function ($view) {
            $view->with('muscleGroups', MuscleGroup::pluck('name', 'id'));
        });

        View::composer(['equipment.*', 'equipment_kinds'], function ($view) {
            $view->with('equipmentKinds', EquipmentKind::pluck('name', 'id'));
        });

        View::composer(['equipment.*', 'equipment_types'], function ($view) {
            $view->with('equipmentTypes', EquipmentType::pluck('name', 'id'));
        });

        View::composer(['exercises.*', 'difficulty_levels'], function ($view) {
            $view->with('difficultyLevels', DifficultyLevel::pluck('name', 'id'));
        });

        View::composer(['exercises.*', 'users'], function ($view) {
            $view->with('users', User::pluck('name', 'id'));
        });

        View::composer(['exercises.*', 'training_types'], function ($view) {
            $view->with('trainingTypes', TrainingType::pluck('name', 'id'));
        });

        View::composer(['exercises.*', 'exercise_biomechanics'], function ($view) {
            $view->with('exerciseBiomechanics', ExerciseBiomechanics::pluck('name', 'id'));
        });

        View::composer(['exercises.*', 'exercise_force_vectors'], function ($view) {
            $view->with('exerciseForceVector', ExerciseForceVector::pluck('name', 'id'));
        });

        View::composer(['exercises.*', 'muscles'], function ($view) {
            $view->with('muscles', Muscle::pluck('name', 'id'));
        });

        View::composer(['exercises.*', 'muscleGroups'], function ($view) {
            $view->with('muscleGroups', MuscleGroup::pluck('name', 'id'));
        });

        View::composer(['exercises.*', 'exercises'], function ($view) {
            $view->with('replacementExercises', Exercise::pluck('name', 'id')->toArray());
        });

        View::composer(['exercises.*', 'equipments'], function ($view) {
            $view->with('equipments', Equipment::pluck('name', 'id'));
        });

        View::composer(['workouts.*', 'users'], function ($view) {
            $view->with('users', User::pluck('name', 'id'));
        });

        View::composer(['workouts.*', 'training_types'], function ($view) {
            $view->with('trainingTypes', TrainingType::pluck('name', 'id'));
        });

        View::composer(['training_packs.*', 'difficulty_levels'], function ($view) {
            $view->with('difficultyLevels', DifficultyLevel::pluck('name', 'id'));
        });

        View::composer(['posts.*', 'users'], function ($view) {
            $view->with('users', User::pluck('name', 'id'));
        });

        View::composer(['workouts.*', 'exercises'], function ($view) {
            $view->with('exercises', Exercise::pluck('name', 'id'));
        });

        View::composer(['training_packs.*', 'workouts'], function ($view) {
            $view->with('workouts', Workout::pluck('name', 'id'));
        });

        View::composer(['users.*', 'countries'], function ($view) {
            $view->with('countries', Country::pluck('name', 'id'));
        });
    }
}
