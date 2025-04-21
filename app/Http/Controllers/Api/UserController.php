<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\UserRepository;
use App\Http\Resources\User\UserCollection;
use App\Http\Resources\User\UserResource;

class UserController extends Controller
{
    protected $UserRepository;

    public function __construct(UserRepository $UserRepository)
    {
        $this->middleware('auth:api');
        $this->userRepository = $UserRepository;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $filters = [
            'name' => $request->query('name'),
            'limit' => $request->query('limit') ?? 5,
        ];

        $users = $this->userRepository->all($filters);

        $result = new UserCollection($users);

        return response()->json($result, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function save(Request $request)
    {
        $id = intval(request()->get('id', -1));
        $leader = auth()->user();
        
        $user = User::find($id);
        if ($user === null) {
            $userData = [
                'name' => $request->input('name'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'company_id' => $leader->company_id,
                'user_group_id' => $request->input('userGroup'),
                'passwordConfirm' => $request->input('confirmationPassword'),
                'role' => $request->input('role') ?? 2
            ];

            $userRequest = new Request($userData);
            $user = AuthController::createUser($userRequest);

            if (!$user) {
                return response()->json(['message'=>'User saved failed'], 400);
            }
        } else {
            $user = $this->userRepository->update($id, $request->all());

            if (!$user) {
                return response()->json(['message'=>'User updated failed'], 400);
            }
        }

        $users = $this->userRepository->all();

        $result = new UserCollection($users);

        return response()->json($result, 200);
    }

    public function show($id)
    {
        $user = $this->userRepository->find($id);
        $result = new UserResource($user);
        return response()->json($result);
    }

    public function destroy($id)
    {
        return response()->json($this->userRepository->delete($id));
    }
}
