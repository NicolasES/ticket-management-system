<?php

namespace App\Infrastructure\DAOs;

use App\Application\DAOs\UserDAO as UserDAOInterface;
use App\Models\User;

class UserDAO implements UserDAOInterface
{
    public function findByDepartmentId(int $departmentId): array
    {
        return User::select('id', 'name', 'email', 'department_id as departmentId')
            ->where('department_id', $departmentId)
            ->get()
            ->toArray();
    }
}
