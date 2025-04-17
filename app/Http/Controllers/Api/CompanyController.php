<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Repositories\CompanyRepository;
use App\Http\Resources\Company\CompanyCollection;
use App\Http\Resources\Company\CompanyResource;

class CompanyController extends Controller
{
    protected $CompanyRepository;

    public function __construct(CompanyRepository $CompanyRepository)
    {
        $this->middleware('auth:api');
        $this->CompanyRepository = $CompanyRepository;
    }

    public function index(Request $request)
    {
        $filters = [
            'name' => $request->query('name'),
            'leader_user_id' => $request->query('leader_user_id'),
            'limit' => $request->query('limit') ?? 5,
        ];

        $companies = $this->CompanyRepository->all($filters);

        $result = new CompanyCollection($companies);

        return response()->json($result, 200);
    }

    public function save(Request $request) {
        $id = intval(request()->get('id', -1));
        $user = request()->user();

        $company = Company::find($id);
        if ($company === null) {
            $companyId = $this->CompanyRepository->create($request->all());

            if (!$companyId) {
                return response()->json(['message'=>'Company saved failed'], 400);
            }
        } else {
            $company = $this->CompanyRepository->update($id, $request->all());

            if (!$company) {
                return response()->json(['message'=>'Company updated failed'], 400);
            }
        }

        $companies = $this->CompanyRepository->all();

        $result = new CompanyCollection($companies);

        return response()->json($result, 200);
    }

    public function show($id)
    {
        $company = $this->CompanyRepository->find($id);
        $result = new CompanyResource($company);
        return response()->json($result);
    }

    public function destroy($id)
    {
        return response()->json($this->CompanyRepository->delete($id));
    }
}
