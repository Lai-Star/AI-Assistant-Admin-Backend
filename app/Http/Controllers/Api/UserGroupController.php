<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\UserGroup;
use App\Repositories\UserGroupRepository;
use App\Http\Resources\UserGroup\UserGroupCollection;
use App\Http\Resources\UserGroup\UserGroupResource;

class UserGroupController extends Controller
{
    protected $UserGroupRepository;

    public function __construct(UserGroupRepository $UserGroupRepository)
    {
        $this->middleware('auth:api');
        $this->userGroupRepository = $UserGroupRepository;
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
        
        $users = $this->userGroupRepository->all($filters);

        $result = new UserGroupCollection($users);

        return response()->json($result, 200);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function save(Request $request)
    {
        $id = intval(request()->get('id', -1));

        $group = UserGroup::find($id);
        if ($group === null) {
            $validated = $request->validate([
                'name' => 'required'
            ]);

            $user = auth()->user();
            $validated['created_by'] = $user->id; 
            $validated['company_id'] = $user->company_id; 
            $validated['member_cnt'] = 0; 

            $groupId = $this->userGroupRepository->create($validated);

            if (!$groupId) {
                return response()->json(['message'=>'User group saved failed'], 400);
            }
        } else {
            $group = $this->userGroupRepository->update($id, $request->all());

            if (!$group) {
                return response()->json(['message'=>'User group updated failed'], 400);
            }
        }

        $groups = $this->userGroupRepository->all();

        $result = new UserGroupCollection($groups);

        return response()->json($result, 200);
    }

    public function show($id)
    {
        $group = $this->userGroupRepository->find($id);
        $result = new UserGroupResource($group);
        return response()->json($result);
    }

    public function destroy($id)
    {
        return response()->json($this->userGroupRepository->delete($id));
    }
}
