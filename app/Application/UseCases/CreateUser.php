<?php

namespace App\Application\UseCases;

use App\Application\DTOs\Input\CreateUserInput;
use App\Domain\Entities\User;
use App\Domain\Repositories\UserRepository;
use App\Infrastructure\Persistence\DepartmentsRepository;
use Pest\Support\Arr;

class CreateUser {
    public function __construct(
        private UserRepository $userRepository,
        private DepartmentsRepository $departmentRepository
    ) {}

    /**
     * @return array{id: int, name: string, email: string, department_id: int}
     */
    public function execute(CreateUserInput $input): array {
        $department = $this->departmentRepository->findById($input->departmentId);
        if (!$department) {
            throw new \Exception('Department not found');
        }
        $user = new User($input->email, $input->name, $input->password, $input->departmentId);
        $this->userRepository->save($user);
        return [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
            'department_id' => $user->getDepartmentId(),
        ];
    }
}