<?php

namespace App\Http\Controllers\API;

use App\Models\Exercise;
use App\Models\User;
use App\Repositories\ExerciseRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class ExerciseController
 * @package App\Http\Controllers\API
 */
class ExerciseAPIController extends AppBaseController
{
    /** @var  ExerciseRepository */
    private $exerciseRepository;

    /**
     *
     * @SWG\Tag(
     *   name="Exercise",
     *   description="Operations with the Exercises"
     * ),
     * @SWG\Response(
     *          response="Exercises",
     *          description="Array of Exercise objects",
     *          ref="$/responses/200",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="data",
     *                  @SWG\Items(ref="#/definitions/ExerciseGet"),
     *              )
     *          )
     * ),
     * @SWG\Response(
     *          response="Exercise",
     *          ref="$/responses/200",
     *          description="Exercise object",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/ExerciseGet"
     *              )
     *          )
     * ),
     */
    public function __construct(ExerciseRepository $exerciseRepo)
    {
        $this->exerciseRepository = $exerciseRepo;
        $this->middleware('auth:api');
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/exercises",
     *      summary="Get a listing of the Exercises.",
     *      tags={"Exercise"},
     *     security={{"api_token":{}}},
     *      @SWG\Parameter(
     *          in="query",
     *          name="api_token",
     *          type="string",
     *          description="Api token",
     *          required=true,
     *      ),
     *      @SWG\Response(response=200, ref="#/responses/Exercises"),
     * )
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $this->exerciseRepository->pushCriteria(new RequestCriteria($request));

        $exercises = $this->exerciseRepository->all();

        return $this->sendResponse($exercises->toArray(), 'Exercises retrieved successfully');
    }

    /**
     * @param int $id
     * @return Response|JsonResponse
     *
     * @SWG\Get(
     *      path="/exercises/{id}",
     *      summary="Display the specified Exercise",
     *      tags={"Exercise"},
     *     security={{"api_token":{}}},
     *      @SWG\Parameter(
     *          in="query",
     *          name="api_token",
     *          type="string",
     *          description="Api token",
     *          required=true,
     *      ),
     *      @SWG\Parameter(ref="$/parameters/id_in_path_required", description="id of Exercise"),
     *      @SWG\Response(response=200, ref="#/responses/Exercise"),
     *      @SWG\Response(response="404", description="Exercise not found"),
     * )
     */
    public function show($id)
    {
        /** @var Exercise $exercise */
        $exercise = $this->exerciseRepository->find($id);

        if (!$exercise) {
            return $this->sendError('Exercise not found');
        }

        return $this->sendResponse($exercise->toArray(), 'Exercise retrieved successfully');
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     *
     * @SWG\Post(
     *      path="/exercises/add-to-favorites",
     *      summary="Adds an Exercise to user's favorites",
     *      tags={"Exercise"},
     *     security={{"api_token":{}}},
     *      @SWG\Parameter(
     *          in="query",
     *          name="api_token",
     *          type="string",
     *          description="Api token",
     *          required=true,
     *      ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="user_id",
     *          type="integer",
     *          description="id of User",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          in="formData",
     *          name="exercise_id",
     *          type="integer",
     *          description="id of Exercise",
     *          required=true,
     *      ),
     *      @SWG\Response(response=200, description="Exercise added to user's favorites"),
     *      @SWG\Response(response="404", description="Exercise or User not found"),
     * )
     */
    public function addToFavorites(Request $request)
    {
        $userId = $request->get('user_id');
        $exerciseId = $request->get('exercise_id');

        if (!$userId) {
            return $this->sendError('Missing user_id', 400);
        }

        if (!$exerciseId) {
            return $this->sendError('Missing exercise_id', 400);
        }

        /** @var User $user */
        $user = User::find($userId);

        if (!$user) {
            return $this->sendError('User not found', 404);
        }

        $exercise = $this->exerciseRepository->find($exerciseId);

        if (!$exercise) {
            return $this->sendError('Exercise not found', 404);
        }

        $user->favoriteExercises()->attach($exerciseId);


        return $this->sendResponse('', 'Exercise added to users\'s favorites');
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     *
     * @SWG\Delete(
     *      path="/exercises/remove-from-favorites",
     *      summary="Removes an Exercise from user's favorites",
     *      tags={"Exercise"},
     *     security={{"api_token":{}}},
     *      @SWG\Parameter(
     *          in="query",
     *          name="api_token",
     *          type="string",
     *          description="Api token",
     *          required=true,
     *      ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="user_id",
     *          type="string",
     *          description="id of User",
     *          required=true,
     *      ),
     *      @SWG\Parameter(
     *          in="formData",
     *          name="exercise_id",
     *          type="string",
     *          description="id of Exercise",
     *          required=true,
     *      ),
     *      @SWG\Response(response=200, description="Exercise added to user's favorites"),
     *      @SWG\Response(response="404", description="Exercise or User not found"),
     * )
     */
    public function removeFromFavorites(Request $request)
    {
        $userId = $request->get('user_id');
        $exerciseId = $request->get('exercise_id');

        if (!$userId) {
            return $this->sendError('Missing user_id', 400);
        }

        if (!$exerciseId) {
            return $this->sendResponse('Missing exercise_id', 400);
        }

        /** @var User $user */
        $user = User::find($userId);

        if (!$user) {
            return $this->sendError('User not found', 404);
        }

        $exercise = $this->exerciseRepository->find($exerciseId);

        if (!$exercise) {
            return $this->sendError('Exercise not found', 404);
        }

        $user->favoriteExercises()->detach($exerciseId);


        return $this->sendResponse('', 'Exercise removed from users\'s favorites');
    }
}
