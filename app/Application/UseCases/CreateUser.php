<?php

namespace App\Application\UseCases;

use App\Application\DTOs\Input\CreateUserInput;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;

class CreateUser {
    public function __construct(
        private UserRepository $userRepository
    ) {}

    public function execute(CreateUserInput $input): User {
        $user = new User($input->email, $input->name, $input->password, $input->departmentId);
        $this->userRepository->save($user);
        return $user;
    }
}