<?php

namespace App\Application\UseCases;

use App\Application\DTOs\Output\LoginUserOutput;
use App\Application\Services\TokenGeneratorInterface;
use App\Domain\Repositories\UserRepository;
use Exception;

class ImpersonateUser {
    public function __construct(
        private UserRepository $userRepository,
        private TokenGeneratorInterface $tokenGenerator,
    ) {}

    public function execute(int $userId): LoginUserOutput {
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new Exception('User not found');
        }
        $token = $this->tokenGenerator->generate($user);

        return new LoginUserOutput($user, $token);
    }
}
