<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\User;

interface UserRepository {
    public function save(User $user): User;
    public function findById(int $id): ?User;
    public function findByEmail(string $email): ?User;
}