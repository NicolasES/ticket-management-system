<?php

use App\Application\DTOs\Input\CreateUserInput;
use App\Application\UseCases\CreateUserUseCase;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

test('should create a new user', function () {
    $userRepository = Mockery::mock(UserRepository::class);
    $userRepository->shouldReceive('save')->once();
    $createUserUseCase = new CreateUserUseCase($userRepository);
    $input = new CreateUserInput('test@test.com', 'Test');
    $output = $createUserUseCase->execute($input);
    expect($output)->toBeInstanceOf(User::class);
});