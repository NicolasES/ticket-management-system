<?php

namespace App\Application\DAOs;

interface UserDAO
{
    /**
     * @param int $departmentId
     * @return array<int, array{id: int, name: string, email: string, departmentId: int}>
     */
    public function findByDepartmentId(int $departmentId): array;
}
