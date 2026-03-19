<?php

use App\Application\DAOs\UserDAO;
use App\Application\UseCases\GetUsersByDepartmentId;

test('should return users array by department id', function () {
    $expectedUsers = [
        ['id' => 1, 'name' => 'User One', 'email' => 'user1@test.com', 'department_id' => 1],
        ['id' => 2, 'name' => 'User Two', 'email' => 'user2@test.com', 'department_id' => 1],
    ];

    $userDAO = Mockery::mock(UserDAO::class);
    $userDAO->shouldReceive('findByDepartmentId')
        ->once()
        ->with(1)
        ->andReturn($expectedUsers);

    $useCase = new GetUsersByDepartmentId($userDAO);
    $result = $useCase->execute(1);

    expect($result)->toBe($expectedUsers);

    Mockery::close();
});
