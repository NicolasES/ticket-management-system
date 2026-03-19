<?php

namespace App\Infrastructure\DAOs;

use App\Application\DAOs\UserDAO as UserDAOInterface;
use App\Models\User;

class UserDAO implements UserDAOInterface
{
    public function findByDepartmentId(int $departmentId): array
    {
        return User::where('department_id', $departmentId)
            ->get(['id', 'name', 'email', 'department_id'])
            ->toArray();
    }
}
