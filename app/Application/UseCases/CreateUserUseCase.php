<?php

namespace App\Application\UseCases;

use App\Application\DTOs\CreateUserDTO;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

class CreateUserUseCase {
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function execute(CreateUserDTO $createUserDTO) {
        $user = new User($createUserDTO->email, $createUserDTO->name);
        $this->userRepository->save($user);
    }
}