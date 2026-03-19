<?php

use App\Application\DTOs\Input\LoginUserInput;
use App\Application\DTOs\Output\LoginUserOutput;
use App\Application\Services\TokenGeneratorInterface;
use App\Application\UseCases\LoginUser;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;
use App\Domain\Services\PasswordHasherInterface;

test('should login successfully and return the correct output', function () {
    $user = new User('test@test.com', 'Test User', 'hashed_pass', '1');
    $user->setId(1);

    $userRepository = Mockery::mock(UserRepository::class);
    $userRepository->shouldReceive('findByEmail')->with('test@test.com')->andReturn($user);

    $tokenGenerator = Mockery::mock(TokenGeneratorInterface::class);
    $tokenGenerator->shouldReceive('generate')->with($user)->andReturn('fake-token');

    $passwordHasher = Mockery::mock(PasswordHasherInterface::class);
    $passwordHasher->shouldReceive('check')->with('secret123', 'hashed_pass')->andReturn(true);

    $loginUser = new LoginUser($userRepository, $tokenGenerator, $passwordHasher);
    $input = new LoginUserInput('test@test.com', 'secret123');

    $output = $loginUser->execute($input);

    expect($output)->toBeInstanceOf(LoginUserOutput::class);
    expect($output->access_token)->toBe('fake-token');
    expect($output->token_type)->toBe('Bearer');
    expect($output->user['id'])->toBe(1);
    
    Mockery::close();
});

test('should throw an exception for invalid credentials', function () {
    $userRepository = Mockery::mock(UserRepository::class);
    $userRepository->shouldReceive('findByEmail')->andReturn(null);
    
    $tokenGenerator = Mockery::mock(TokenGeneratorInterface::class);
    $passwordHasher = Mockery::mock(PasswordHasherInterface::class);

    $loginUser = new LoginUser($userRepository, $tokenGenerator, $passwordHasher);
    $input = new LoginUserInput('wrong@email.com', 'any');

    expect(fn() => $loginUser->execute($input))->toThrow(\Exception::class, 'Invalid credentials');
    
    Mockery::close();
});
