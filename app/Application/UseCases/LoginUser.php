<?php

namespace App\Application\UseCases;

use App\Application\DTOs\Input\LoginUserInput;
use App\Application\DTOs\Output\LoginUserOutput;
use App\Application\Services\TokenGeneratorInterface;
use App\Domain\Repositories\UserRepository;
use App\Domain\Services\PasswordHasherInterface;
use Exception;

class LoginUser {
    public function __construct(
        private UserRepository $userRepository,
        private TokenGeneratorInterface $tokenGenerator,
        private PasswordHasherInterface $passwordHasher
    ) {}

    public function execute(LoginUserInput $input): LoginUserOutput {
        $user = $this->userRepository->findByEmail($input->email);
        if (!$user || !$this->passwordHasher->check($input->password, $user->getPassword())) {
            throw new Exception('Invalid credentials');
        }
        $token = $this->tokenGenerator->generate($user);

        return new LoginUserOutput($user, $token);
    }
}
