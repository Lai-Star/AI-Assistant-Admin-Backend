<?php
// app/Repository/CompanyRepository.php
namespace App\Repositories;

use App\Models\Company;

class CompanyRepository implements CompanyRepositoryInterface
{
    public function all(array $filters = [])
    {   
        $filters['limit'] = 5;
        $query = Company::query();

        if (!empty($filters['name'])) {
            $query->where('name', 'like', '%' . $filters['name'] . '%');
        }

        return $query->orderByDesc('created_at')->paginate($filters['limit']);
    }

    public function find($id)
    {
        return Company::findOrFail($id);
    }

    public function create(array $data)
    {
        return Company::create($data);
    }

    public function update($id, array $data)
    {
        $company = Company::findOrFail($id);
        $company->update($data);
        return $company;
    }

    public function delete($id)
    {
        return Company::destroy($id);
    }
}

?>
