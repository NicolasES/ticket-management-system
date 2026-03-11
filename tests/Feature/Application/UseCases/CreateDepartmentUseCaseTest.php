<?php

use App\Application\UseCases\CreateDepartmentUseCase;
use App\Application\DTOs\Input\CreateDepartmentInput;
use App\Domain\Entities\Department;
use App\Domain\Repositories\DepartmentRepository;

test('should create a new department', function() {
    $departmentRepository = Mockery::mock(DepartmentRepository::class);
    $mockDepartment = new Department('DepartmentName');
    $mockDepartment->setId(1);

    $departmentRepository->shouldReceive('save')
        ->once()
        ->andReturn($mockDepartment);
    $createDepartmentUseCase = new CreateDepartmentUseCase($departmentRepository);
    $input = new CreateDepartmentInput('DepartmentName');
    $output = $createDepartmentUseCase->execute($input);
    expect($output->id)->toBe(1);
    expect($output->name)->toBe('DepartmentName');
});