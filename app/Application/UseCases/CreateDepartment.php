<?php

namespace App\Application\UseCases;

use App\Application\DTOs\Input\CreateDepartmentInput;
use App\Application\DTOs\Output\CreateDepartmentOutput;
use App\Domain\Entities\Department;
use App\Domain\Repositories\DepartmentRepository;

class CreateDepartment {
    public function __construct(
        private DepartmentRepository $departmentRepository
    ) {}

    public function execute(CreateDepartmentInput $input): CreateDepartmentOutput {
        $department = new Department($input->name);
        $department = $this->departmentRepository->save($department);
        return new CreateDepartmentOutput($department->getId(), $department->getName());
    }
}
