<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateExerciseRequest;
use App\Http\Requests\UpdateExerciseRequest;
use App\Models\Exercise;
use App\Repositories\ExerciseRepository;
use App\Util\ImageManager;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Flash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Response;

class ExerciseController extends AppBaseController
{
    /** @var  ExerciseRepository */
    private $exerciseRepository;

    public function __construct(ExerciseRepository $exerciseRepo)
    {
        $this->exerciseRepository = $exerciseRepo;
    }

    /**
     * Display a listing of the Exercise.
     *
     * @param Request $request
     *
     * @return Response
     */
    public function index(Request $request)
    {
        $exercises = $this->exerciseRepository->all();

        return view('exercises.index')
            ->with('exercises', $exercises);
    }

    /**
     * Show the form for creating a new Exercise.
     *
     * @return Response
     */
    public function create()
    {
        return view('exercises.create')
            ->with('exercise', new Exercise());
    }

    /**
     * Store a newly created Exercise in storage.
     *
     * @param CreateExerciseRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateExerciseRequest $request)
    {
        $input = $request->all();

        $input['author_id'] = Auth::id();

        $exercise = $this->exerciseRepository->create($input);

        $muscleGroups = $request->get('muscle_groups') ?? [];

        foreach ($muscleGroups as $muscleGroup) {
            $exercise->muscleGroups()->attach($muscleGroup, ['is_additional_muscle_group' => false]);
        }

        $additionalMuscleGroups = $request->get('additional_muscle_groups') ?? [];

        foreach ($additionalMuscleGroups as $additionalMuscleGroup) {
            $exercise->muscleGroups()->attach($additionalMuscleGroup, ['is_additional_muscle_group' => true]);
        }

        $replacementExercises = $request->get('replacement_exercises') ?? [];

        foreach ($replacementExercises as $replacementExercise) {
            $exercise->replacementExercises()->attach($replacementExercise);
        }

        $equipments = $request->get('equipments') ?? [];

        foreach ($equipments as $equipment) {
            $exercise->equipments()->attach($equipment);
        }

        $positivePhaseDuration = $request->get('positive_phase_duration') ?? '';
        $positivePhaseBreath = $request->get('positive_phase_breath') ?? '';

        $negativePhaseDuration = $request->get('negative_phase_duration') ?? '';
        $negativePhaseBreath = $request->get('negative_phase_breath') ?? '';

        $exercise->positive_phase = [
            'duration' => $positivePhaseDuration,
            'breath' => $positivePhaseBreath
        ];

        $exercise->negative_phase = [
            'duration' => $negativePhaseDuration,
            'breath' => $negativePhaseBreath
        ];

        $images = $request->file('images');

        if ($images) {
            foreach ($images as $image) {
                $path = ImageManager::upload($image, Exercise::FILE_DIR . $exercise->id);
                $exercise->images()->create(['path' => $path]);
            }
        }

        $exercise->save();

        Flash::success('Exercise saved successfully.');

        return redirect(route('exercises.index'));
    }

    /**
     * Display the specified Exercise.
     *
     * @param int $id
     *
     * @return Response
     */
    public function show($id)
    {
        /** @var Exercise $exercise */
        $exercise = $this->exerciseRepository
            ->with([
                'muscleGroups',
                'additionalMuscleGroups',
                'replacementExercises',
                'equipments',
                'images'
            ])
            ->find($id);

        if (empty($exercise)) {
            Flash::error('Exercise not found');

            return redirect(route('exercises.index'));
        }

        return view('exercises.show')
            ->with('exercise', $exercise);
    }

    /**
     * Show the form for editing the specified Exercise.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        /** @var Exercise $exercise */
        $exercise = $this->exerciseRepository
            ->with(['muscleGroups', 'additionalMuscleGroups', 'replacementExercises', 'equipments'])
            ->find($id);

        if (empty($exercise)) {
            Flash::error('Exercise not found');

            return redirect(route('exercises.index'));
        }

        return view('exercises.edit')
            ->with('exercise', $exercise);
    }

    /**
     * Update the specified Exercise in storage.
     *
     * @param int $id
     * @param UpdateExerciseRequest $request
     *
     * @return Response
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update($id, UpdateExerciseRequest $request)
    {
        $exercise = $this->exerciseRepository->find($id);

        $input['author_id'] = Auth::id();

        if (empty($exercise)) {
            Flash::error('Exercise not found');

            return redirect(route('exercises.index'));
        }

        $positivePhaseDuration = $request->get('positive_phase_duration') ?? '';
        $positivePhaseBreath = $request->get('positive_phase_breath') ?? '';

        $negativePhaseDuration = $request->get('negative_phase_duration') ?? '';
        $negativePhaseBreath = $request->get('negative_phase_breath') ?? '';

        $exercise->positive_phase = [
            'duration' => $positivePhaseDuration,
            'breath' => $positivePhaseBreath
        ];

        $exercise->negative_phase = [
            'duration' => $negativePhaseDuration,
            'breath' => $negativePhaseBreath
        ];

        $exercise->save();

        $exercise = $this->exerciseRepository->update($request->all(), $id);

        $muscleGroups = $request->get('muscle_groups') ?? [];

        $exercise->muscleGroups()->detach();

        foreach ($muscleGroups as $muscleGroup) {
            $exercise->muscleGroups()->attach($muscleGroup, ['is_additional_muscle_group' => false]);
        }

        $exercise->additionalMuscleGroups()->detach();

        $additionalMuscleGroups = $request->get('additional_muscle_groups') ?? [];

        foreach ($additionalMuscleGroups as $additionalMuscleGroup) {
            $exercise->muscleGroups()->attach($additionalMuscleGroup, ['is_additional_muscle_group' => true]);
        }

        $replacementExercises = $request->get('replacement_exercises') ?? [];

        $exercise->replacementExercises()->detach();

        foreach ($replacementExercises as $replacementExercise) {
            $exercise->replacementExercises()->attach((int)$replacementExercise);
        }

        $equipments = $request->get('equipments') ?? [];

        $exercise->equipments()->detach();

        foreach ($equipments as $equipment) {
            $exercise->equipments()->attach($equipment);
        }

        $images = $request->file('images');

        if ($images) {
            if ($exercise->images->isNotEmpty()) {
                ImageManager::remove($exercise->images);
                if (Storage::exists(Exercise::FILE_DIR . $exercise->id)) {
                    Storage::deleteDirectory(Exercise::FILE_DIR . $exercise->id);
                }
            }

            foreach ($images as $image) {
                $path = ImageManager::upload($image, Exercise::FILE_DIR . $exercise->id);
                $exercise->images()->create(['path' => $path]);
            }
        }

        Flash::success('Exercise updated successfully.');

        return redirect(route('exercises.index'));
    }

    /**
     * Remove the specified Exercise from storage.
     *
     * @param int $id
     *
     * @throws \Exception
     *
     * @return Response
     */
    public function destroy($id)
    {
        $exercise = $this->exerciseRepository->find($id);

        if (empty($exercise)) {
            Flash::error('Exercise not found');

            return redirect(route('exercises.index'));
        }

        $exercise->replacementExercises()->detach();

        $exercise->equipments()->detach();

        $exercise->muscleGroups()->detach();

        $exercise->additionalMuscleGroups()->detach();

        /** @var Collection $images */
        $images = $exercise->images;

        if ($images->isNotEmpty()) {
            ImageManager::remove($images);

            if (Storage::exists(Exercise::FILE_DIR . $exercise->id)) {
                Storage::deleteDirectory(Exercise::FILE_DIR . $exercise->id);
            }
        }

        $this->exerciseRepository->delete($id);

        Flash::success('Exercise deleted successfully.');

        return redirect(route('exercises.index'));
    }
}
