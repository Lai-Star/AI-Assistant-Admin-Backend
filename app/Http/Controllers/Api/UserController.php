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
        $this->UserRepository = $UserRepository;
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

        $users = $this->UserRepository->all($filters);

        $result = new UserCollection($users);

        return response()->json($result, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function save()
    {
        $id = intval(request()->get('id', -1));

        $user = User::find($id);
        if ($user === null) {
            $userId = $this->userRepository->create($request->all());

            if (!$userId) {
                return response()->json(['message'=>'User saved failed'], 400);
            }
        } else {
            $user = $this->UserRepository->update($id, $request->all());

            if (!$user) {
                return response()->json(['message'=>'User updated failed'], 400);
            }
        }

        $users = $this->UserRepository->all();

        $result = new UserCollection($users);

        return response()->json($result, 200);
    }

    public function show($id)
    {
        $user = $this->UserRepository->find($id);
        $result = new UserResource($user);
        return response()->json($result);
    }

    public function destroy($id)
    {
        return response()->json($this->UserRepository->delete($id));
    }
}
