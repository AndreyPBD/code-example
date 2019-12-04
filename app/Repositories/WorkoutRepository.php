<?php

namespace App\Repositories;

use App\Models\Workout;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class WorkoutRepository
 * @package App\Repositories
 */
class WorkoutRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'name',
        'author_id',
        'training_type_id',
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return Workout::class;
    }

    public function getWorkoutExercises($exercisesCollection)
    {
        $exercisesInfo = [];

        foreach ($exercisesCollection as $exercises) {

            $exerciseInfo['exerciseId'] = $exercises['id'];
            $exerciseInfo['sets'] = $exercises['pivot']['sets'];
            $exerciseInfo['reps'] = $exercises['pivot']['reps'];
            $exerciseInfo['break_time'] = $exercises['pivot']['break_time'];
            $exerciseInfo['weight'] = $exercises['pivot']['weight'];
            $exerciseInfo['sort'] = $exercises['pivot']['sort'];

            $exercisesInfo[] = $exerciseInfo;

            unset($exerciseInfo);
        }

        return $exercisesInfo;
    }

    public function createWorkout($input)
    {
        $workout = $this->create($input);

        $exercisesInfo = json_decode($input['ExercisesInfo'], true) ?? [];

        foreach ($exercisesInfo as $exerciseInfo) {
            $workout->exercises()->attach(
                $exerciseInfo['exerciseId'],
                [
                    'sets' => $exerciseInfo['sets'],
                    'reps' => $exerciseInfo['reps'],
                    'break_time' => $exerciseInfo['break_time'] ?? 0,
                    'weight' => $exerciseInfo['weight'] ?? 0,
                    'sort' => $exerciseInfo['sort'] ?? 0,
                ]
            );
        }
    }
}
