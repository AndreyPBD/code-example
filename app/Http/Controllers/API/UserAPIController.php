<?php

namespace App\Http\Controllers\API;

use App\Http\Requests\API\CreateUserAPIRequest;
use App\Http\Requests\API\UpdateUserAPIRequest;
use App\Models\Invitation;
use App\Models\User;
use App\Repositories\InvitationRepository;
use App\Repositories\UserRepository;
use App\Util\Mailer;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\AppBaseController;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Str;
use Prettus\Repository\Criteria\RequestCriteria;
use Response;

/**
 * Class UserController
 * @package App\Http\Controllers\API
 */
class UserAPIController extends AppBaseController
{
    use AuthenticatesUsers;

    /** @var  UserRepository */
    private $userRepository;

    /** @var InvitationRepository */
    private $invitationRepo;

    /** @var Mailer */
    private $mailer;

    /**
     *
     * @SWG\Tag(
     *   name="User",
     *   description="Operations with the Users"
     * ),
     * @SWG\Response(
     *          response="Users",
     *          description="Array of User objects",
     *          ref="$/responses/200",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="data",
     *                  @SWG\Items(ref="#/definitions/UserGet"),
     *              )
     *          )
     * ),
     * @SWG\Response(
     *          response="User",
     *          ref="$/responses/200",
     *          description="User object",
     *          @SWG\Schema(
     *              @SWG\Property(
     *                  property="data",
     *                  ref="#/definitions/UserGet"
     *              )
     *          )
     * ),
     */
    public function __construct(
        UserRepository $userRepo,
        InvitationRepository $invitationRepo,
        Mailer $mailer
    )
    {
        $this->userRepository = $userRepo;
        $this->invitationRepo = $invitationRepo;
        $this->mailer = $mailer;

        $this->middleware('auth:api')->except([
            'checkEmail',
            'sendInvitation',
            'checkCode',
            'store',
            'login'
        ]);

        $this->middleware('guest')->only([
            'checkEmail',
            'sendInvitation',
            'checkCode',
            'store',
            'login'
        ]);
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     *
     * @SWG\Post(
     *      path="/users/check-email",
     *      summary="Check email uniqueness",
     *      tags={"User"},
     *      @SWG\Parameter(
     *          in="formData",
     *          name="email",
     *          type="string",
     *          description="User's email",
     *          required=true,
     *      ),
     *      @SWG\Response(response="200", description="No users found, email is valid"),
     *      @SWG\Response(response="422", description="User with this email already exists"),
     * )
     */
    public function checkEmail(Request $request)
    {
        $email = $request->get('email');

        if (!$email) {
            return $this->sendError('Missing email', 422);
        }

        $isUserExists = User::where('email', $email)->get();

        if ($isUserExists->isNotEmpty()) {
            return $this->sendError('User already exists', 422);
        }

        return $this->sendResponse('', 'Email is valid');
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     *
     * @SWG\Post(
     *      path="/users/send-invitation",
     *      summary="Sends invitation to registration",
     *      tags={"User"},
     *      @SWG\Parameter(
     *          in="formData",
     *          name="email",
     *          type="string",
     *          description="User's email",
     *          required=true,
     *      ),
     *      @SWG\Response(response="200", description="Returns success"),
     *      @SWG\Response(response="412", description="Required parameter missing"),
     * )
     * @throws \Exception
     */
    public function sendInvitation(Request $request)
    {
        $email = $request->get('email');

        if (!$email) {
            return $this->sendError('Missing email', 412);
        }

        $input['email'] = $email;
        $input['code'] = random_int(100000, 999999);

        $invitation = $this->invitationRepo->create($input);

        $this->mailer->sendEmail($email, $input['code']);

        return $this->sendResponse('', 'Invite sent');
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     *
     * @SWG\Post(
     *      path="/users/check-code",
     *      summary="Matches user email and code with db records",
     *      tags={"User"},
     *      @SWG\Parameter(
     *          in="formData",
     *          name="email",
     *          type="string",
     *          description="User's email",
     *          required=true,
     *      ),
     *     @SWG\Parameter(
     *          in="formData",
     *          name="code",
     *          type="string",
     *          description="Invitation code",
     *          required=true,
     *      ),
     *      @SWG\Response(response="200", description="Returns success"),
     *      @SWG\Response(response="404", description="Email and code combination not found"),
     * )
     * @throws \Exception
     */
    public function checkCode(Request $request)
    {
        $email = $request->get('email');

        if (!$email) {
            return $this->sendError('Missing email', 422);
        }

        $code = $request->get('code');

        if (!$code) {
            return $this->sendError('Missing code', 422);
        }

        $isMatch = Invitation::where('email', $email)->where('code', $code)->get();

        if ($isMatch->isEmpty()) {
            return $this->sendError('Email - code combination not found', 412);
        }

        return $this->sendResponse('', 'Invite found');
    }

    /**
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *      path="/users",
     *      summary="Get a listing of the Users.",
     *      tags={"User"},
     *     security={{"api_token":{}}},
     *      @SWG\Parameter(
     *          in="query",
     *          name="api_token",
     *          type="string",
     *          description="Api token",
     *          required=true,
     *      ),
     *      @SWG\Response(response=200, ref="#/responses/Users"),
     * )
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));

        $users = $this->userRepository->all();

        return $this->sendResponse($users->toArray(), 'Users retrieved successfully');
    }

    /**
     * @param CreateUserAPIRequest $request
     * @return Response
     *
     * @SWG\Post(
     *      path="/users",
     *      summary="Store a newly created User in storage",
     *      tags={"User"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be stored",
     *          @SWG\Schema(ref="#/definitions/UserSet")
     *      ),
     *      @SWG\Response(response=200, ref="#/responses/User"),
     *      @SWG\Response(response="422", ref="#/responses/422"),
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function store(CreateUserAPIRequest $request)
    {
        $input = $request->all();

        $input['password'] = Hash::make($request->get('password'));
        $input['api_token'] = Str::random(60);

        $user = $this->userRepository->create($input);

        $invitation = Invitation::where('email', $request->get('email'))->get();

        Invitation::destroy($invitation->first()->id);

        return $this->sendResponse($user->toArray(), 'User saved successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Get(
     *      path="/users/{id}",
     *      summary="Display the specified User",
     *      tags={"User"},
     *     security={{"api_token":{}}},
     *      @SWG\Parameter(
     *          in="query",
     *          name="api_token",
     *          type="string",
     *          description="Api token",
     *          required=true,
     *      ),
     *      @SWG\Parameter(ref="$/parameters/id_in_path_required", description="id of User"),
     *      @SWG\Response(response=200, ref="#/responses/User"),
     *      @SWG\Response(response="404", description="User not found"),
     * )
     */

    public function show($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        return $this->sendResponse($user->toArray(), 'User retrieved successfully');
    }

    /**
     * @param int $id
     * @param UpdateUserAPIRequest $request
     * @return Response
     *
     * @SWG\Put(
     *      path="/users/{id}",
     *      summary="Update the specified User in storage",
     *      tags={"User"},
     *     security={{"api_token":{}}},
     *      @SWG\Parameter(
     *          in="query",
     *          name="api_token",
     *          type="string",
     *          description="Api token",
     *          required=true,
     *      ),
     *      @SWG\Parameter(ref="$/parameters/id_in_path_required", description="id of User"),
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be updated",
     *          @SWG\Schema(ref="#/definitions/UserSet")
     *      ),
     *      @SWG\Response(response=200, ref="#/responses/User"),
     *      @SWG\Response(response="404", description="User not found"),
     *      @SWG\Response(response="422", ref="#/responses/422"),
     * )
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */

    public function update($id, UpdateUserAPIRequest $request)
    {
        $input = $request->all();

        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user = $this->userRepository->update($input, $id);

        return $this->sendResponse($user->toArray(), 'User updated successfully');
    }

    /**
     * @param int $id
     * @return Response
     *
     * @SWG\Delete(
     *      path="/users/{id}",
     *      summary="Remove the specified User from storage",
     *      tags={"User"},
     *     security={{"api_token":{}}},
     *      @SWG\Parameter(
     *          in="query",
     *          name="api_token",
     *          type="string",
     *          description="Api token",
     *          required=true,
     *      ),
     *      @SWG\Parameter(ref="$/parameters/id_in_path_required", description="id of User"),
     *      @SWG\Response(response=200, ref="#/responses/200"),
     *      @SWG\Response(response="404", description="User not found"),
     * )
     * @throws \Exception
     */

    public function destroy($id)
    {
        /** @var User $user */
        $user = $this->userRepository->find($id);

        if (empty($user)) {
            return $this->sendError('User not found');
        }

        $user->delete();

        return $this->sendResponse($id, 'User deleted successfully');
    }

    /**
     * @param Request $request
     * @return Response|JsonResponse
     *
     * @SWG\Get(
     *      path="/users/favorite-exercises",
     *      summary="User's favorite Exercises",
     *      tags={"User"},
     *     security={{"api_token":{}}},
     *      @SWG\Parameter(
     *          in="query",
     *          name="api_token",
     *          type="string",
     *          description="Api token",
     *          required=true,
     *      ),
     *     @SWG\Parameter(
     *          in="query",
     *          name="user_id",
     *          type="integer",
     *          description="id of User",
     *          required=true,
     *      ),
     *      @SWG\Response(response=200, description="Return list of User's favorite Exercises"),
     * )
     */
    public function favoriteExercises(Request $request)
    {
        $userId = $request->get('user_id');

        if (!$userId) {
            return $this->sendError('Missing user_id', 422);
        }

        /** @var User $user */
        $user = $this->userRepository->find($userId);

        if (!$user) {
            return $this->sendError('User not found', 404);
        }

        $exercises = $user->favoriteExercises()->getResults();

        return $this->sendResponse($exercises, 'User\'s favorite exercise');
    }

    /**
     * @SWG\Post(
     *      path="/login",
     *      tags={"User"},
     *      description="Login user in system. You can use also /login path for same functionality",
     *      produces={"application/json"},
     *      @SWG\Parameter(
     *          name="body",
     *          in="body",
     *          description="User that should be stored",
     *          required=true,
     *          @SWG\Schema(
     *              required={"email", "password"},
     *              @SWG\Property(property="email",  type="string"),
     *              @SWG\Property(property="password",  type="string"),
     *          ),
     *      ),
     *      @SWG\Response(
     *          response=200,
     *          description="Returns User object",
     *      ),
     *      @SWG\Response(
     *         response=401,
     *         description="Unauthorized user",
     *      ),
     * )
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @throws \Illuminate\Validation\ValidationException
     */
    public function login(Request $request)
    {

        $this->validateLogin($request);

        if ($this->attemptLogin($request)) {

            $user = User::find($request->user()->id);

            return $this->sendResponse($user, 'User retrieved successfully');
        }

        return $this->sendError('Unauthenticated.');
    }
}
