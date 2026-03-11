<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Department;

interface DepartmentRepository {
    public function save(Department $department): Department;
    public function findById(int $id): ?Department;
}