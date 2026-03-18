<?php

namespace App\Infrastructure\DAOs;

use App\Application\DAOs\DepartmentDAO as DepartmentDAOInterface;
use App\Models\DepartmentModel;

class DepartmentDAO implements DepartmentDAOInterface
{
    public function findAll(): array
    {
        return DepartmentModel::all()->toArray();
    }
}