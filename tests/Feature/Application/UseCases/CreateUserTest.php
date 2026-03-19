<?php

use App\Application\DTOs\Input\CreateUserInput;
use App\Application\UseCases\CreateUser;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

test('should create a new user', function () {
    $userRepository = Mockery::mock(UserRepository::class);
    $userRepository->shouldReceive('save')->once();
    $createUser = new CreateUser($userRepository);
    $input = new CreateUserInput('test@test.com', 'Test', 'password', '1');
    $output = $createUser->execute($input);
    expect($output)->toBeInstanceOf(User::class);
});