<?php

use App\Application\DTOs\CreateUserDTO;
use App\Application\UseCases\CreateUserUseCase;
use App\Domain\Repositories\UserRepository;
use Mockery;

test('should create a new user', function () {
    $userRepository = Mockery::mock(UserRepository::class);
    $userRepository->shouldReceive('save')->once();
    $createUserUseCase = new CreateUserUseCase($userRepository);
    $createUserDTO = new CreateUserDTO('test@test.com', 'Test');
    $createUserUseCase->execute($createUserDTO);
});