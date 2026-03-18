<?php

namespace App\Application\UseCases;

use App\Application\DAOs\DepartmentDAO;

class GetAllDepartments
{
    public function __construct(private DepartmentDAO $departmentDAO) {}

    /**
     * @return array<int, array{id: int, name: string}>
     */
    public function execute(): array
    {
        return $this->departmentDAO->findAll();
    }
}
