<?php

namespace App\Repositories;

use App\Models\User;
use App\Models\UserGroup;

class UserGroupRepository implements UserGroupRepositoryInterface
{
    public function all(array $filters = [])
    {   
        $filters['limit'] = 5;
        $query = UserGroup::query();
        
        if (!empty($filters['name'])) {
            $query->where('name', 'Ilike', '%' . $filters['name'] . '%');
        }
        
        return $query->orderByDesc('created_at')->paginate($filters['limit']);
    }

    public function find($id)
    {
        return UserGroup::findOrFail($id);
    }

    public function create(array $data)
    {
        return UserGroup::create($data);
    }

    public function update($id, array $data)
    {
        $user = UserGroup::findOrFail($id);
        $user->update($data);
        return $user;
    }

    public function delete($id)
    {
        return UserGroup::destroy($id);
    }
}

?>
