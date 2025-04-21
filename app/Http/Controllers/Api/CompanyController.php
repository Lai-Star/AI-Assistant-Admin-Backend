<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Http\Controllers\Api\AuthController;
use App\Repositories\UserRepository;
use App\Repositories\CompanyRepository;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;

class CompanyController extends Controller
{
    protected $companyRepository;
    protected $userRepository;

    public function __construct(CompanyRepository $companyRepository, UserRepository $userRepository)
    {
        $this->middleware('auth:api');
        $this->companyRepository = $companyRepository;
        $this->userRepository = $userRepository;
    }

    public function index(Request $request)
    {
        $filters = [
            'name' => $request->query('name'),
            'leader_user_id' => $request->query('leader_user_id'),
            'limit' => $request->query('limit') ?? 5,
        ];

        $companies = $this->companyRepository->all($filters);

        $result = new CompanyCollection($companies);

        return response()->json($result, 200);
    }

    public function save(Request $request) {
        $id = intval(request()->get('id', -1));

        $company = Company::find($id);
        if ($company === null) {
            $leaderData = [
                'name' => $request->input('leaderName'),
                'email' => $request->input('email'),
                'password' => $request->input('password'),
                'passwordConfirm' => $request->input('confirmationPassword'),
                'role' => $request->input('role') ?? 1
            ];

            $leaderRequest = new Request($leaderData);
            $leader = AuthController::createUser($leaderRequest);

            if (!isset($leader) || !isset($leader->id)) {
                return response()->json(['message' => 'Leader registration failed'], 400);
            }

            $leaderUserId = $leader->id;
            $companyData = $request->all();
            $companyData['leader_user_id'] = $leaderUserId;
            $company = $this->companyRepository->create($companyData);

            if (!$company) {
                return response()->json(['message'=>'Company creation failed'], 400);
            }

            $leader->company_id = $company->id;
            $leader->save();
        } else {
            $company = $this->companyRepository->update($id, $request->all());

            if (!$company) {
                return response()->json(['message'=>'Company updated failed'], 400);
            }
        }

        $companies = $this->companyRepository->all();

        $result = new CompanyCollection($companies);

        return response()->json($result, 200);
    }

    public function show($id)
    {
        $company = $this->companyRepository->find($id);
        $result = new CompanyResource($company);
        return response()->json($result);
    }

    public function destroy($id)
    {
        return response()->json($this->companyRepository->delete($id));
    }
}
