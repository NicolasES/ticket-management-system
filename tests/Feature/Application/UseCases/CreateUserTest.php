<?php

use App\Application\DTOs\Input\CreateUserInput;
use App\Application\UseCases\CreateUser;
use App\Domain\Entities\Department;
use App\Domain\Entities\User;
use App\Domain\Repositories\DepartmentRepository;
use App\Domain\Repositories\UserRepository;

test('should create a new user', function () {
    $userRepository = Mockery::mock(UserRepository::class);
    $userRepository->shouldReceive('save')->once();

    $departmentRepository = Mockery::mock(DepartmentRepository::class);
    $departmentRepository->shouldReceive('findById')->once()->andReturn(new Department(1, 'Test'));

    $createUser = new CreateUser($userRepository, $departmentRepository);

    $input = new CreateUserInput('test@test.com', 'Test', 'password', 1);
    $output = $createUser->execute($input);

    expect($output)->toBeArray();
    expect($output)->toHaveKeys(['id', 'name', 'email', 'department_id']);
    expect($output['name'])->toBe('Test');
    expect($output['email'])->toBe('test@test.com');
    expect($output['department_id'])->toBe(1);
});
