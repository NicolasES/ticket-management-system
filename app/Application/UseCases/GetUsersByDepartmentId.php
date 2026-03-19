<?php

namespace App\Application\UseCases;

use App\Application\DAOs\UserDAO;

class GetUsersByDepartmentId
{
    public function __construct(private UserDAO $userDAO) {}

    /**
     * @param int $departmentId
     * @return array<int, array{id: int, name: string, email: string, department_id: int}>
     */
    public function execute(int $departmentId): array
    {
        return $this->userDAO->findByDepartmentId($departmentId);
    }
}
