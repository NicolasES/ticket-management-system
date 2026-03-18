<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Entities\Department;
use App\Domain\Repositories\DepartmentRepository as DepartmentRepositoryInterface;
use App\Models\DepartmentModel;

class DepartmentsRepository implements DepartmentRepositoryInterface
{
    public function save(Department $department): Department
    {
        $departmentModel = DepartmentModel::create([
            'name' => $department->getName(),
        ]);
        $department = new Department($departmentModel->name);
        $department->setId($departmentModel->id);
        return $department;
    }

    public function findById(int $id): ?Department
    {
        $departmentModel = DepartmentModel::find($id);
        if (!$departmentModel) {
            return null;
        }
        $department = new Department($departmentModel->name);
        $department->setId($departmentModel->id);
        return $department;
    }
}