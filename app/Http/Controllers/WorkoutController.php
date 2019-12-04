<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;
use App\Models\Exercise;
use App\Repositories\WorkoutRepository;
use App\Http\Controllers\AppBaseController;
use Illuminate\Http\Request;
use Flash;
use Response;

class WorkoutController extends AppBaseController
{
    /** @var  WorkoutRepository */
    private $workoutRepository;

    public function __construct(WorkoutRepository $workoutRepo)
    {
        $this->workoutRepository = $workoutRepo;
    }

    /**
     * Display a listing of the Workout.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $workouts = $this->workoutRepository->all();

        return view('workouts.index')
            ->with('workouts', $workouts);
    }

    /**
     * Show the form for creating a new Workout.
     *
     * @return Response
     */
    public function create()
    {
        return view('workouts.create');
    }

    /**
     * Store a newly created Workout in storage.
     *
     * @param CreateWorkoutRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateWorkoutRequest $request)
    {
        $input = $request->all();

        $workout = $this->workoutRepository->createWorkout($input);

        Flash::success('Workout saved successfully.');

        return redirect(route('workouts.index'));
    }

    /**
     * Display the specified Workout.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        $workout = $this->workoutRepository->find($id);

        if (empty($workout)) {
            Flash::error('Workout not found');

            return redirect(route('workouts.index'));
        }

        $exercisesCollection = $workout->exercises()
            ->withPivot('sets', 'reps', 'break_time', 'weight', 'sort')->get()->toArray();

        $exercisesInfo = $this->workoutRepository->getWorkoutExercises($exercisesCollection);

        return view('workouts.show')
            ->with('workout', $workout)
            ->with('exercisesInfo', json_encode($exercisesInfo));
    }

    /**
     * Show the form for editing the specified Workout.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        $workout = $this->workoutRepository->find($id);

        if (empty($workout)) {
            Flash::error('Workout not found');

            return redirect(route('workouts.index'));
        }

        $exercisesCollection = $workout->exercises()
            ->withPivot('sets', 'reps', 'break_time', 'weight', 'sort')->get()->toArray();

        $exercisesInfo = $this->workoutRepository->getWorkoutExercises($exercisesCollection);

        return view('workouts.edit')
            ->with('workout', $workout)
            ->with('exercisesInfo', json_encode($exercisesInfo));
    }

    /**
     * Update the specified Workout in storage.
     *
     * @param int $id
     * @param UpdateWorkoutRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateWorkoutRequest $request)
    {
        $workout = $this->workoutRepository->find($id);

        if (empty($workout)) {
            Flash::error('Workout not found');

            return redirect(route('workouts.index'));
        }

        $workout = $this->workoutRepository->update($request->all(), $id);

        $workout->exercises()->detach();

        $input = $request->all();

        $exercisesInfo = json_decode($input['ExercisesInfo'], true) ?? [];

        $this->workoutRepository->createWorkoutExercises($workout, $exercisesInfo);

        Flash::success('Workout updated successfully.');

        return redirect(route('workouts.index'));
    }

    /**
     * Remove the specified Workout from storage.
     *
     * @param int $id
     *
     * @return Response
     * @throws \Exception
     *
     */
    public function destroy($id)
    {
        $workout = $this->workoutRepository->find($id);

        if (empty($workout)) {
            Flash::error('Workout not found');

            return redirect(route('workouts.index'));
        }

        $workout->exercises()->detach();

        $this->workoutRepository->delete($id);

        Flash::success('Workout deleted successfully.');

        return redirect(route('workouts.index'));
    }
}
