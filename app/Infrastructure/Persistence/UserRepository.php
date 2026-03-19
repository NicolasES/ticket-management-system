<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Repositories\UserRepository as UserRepositoryInterface;
use App\Domain\Entities\User;
use App\Models\User as UserModel;

class UserRepository implements UserRepositoryInterface {
    public function save(User $user): User {
        $userModel = UserModel::create([
            'email' => $user->getEmail(),
            'name' => $user->getName(),
            'password' => $user->getPassword(),
            'department_id' => $user->getDepartmentId(),
        ]);
        $user->setId($userModel->id);
        return $user;
    }

    public function findById(int $id): ?User {
        $userModel = UserModel::find($id);
        if ($userModel) {
            $user = new User($userModel->email, $userModel->name, $userModel->password, $userModel->department_id);
            $user->setId($userModel->id);
            return $user;
        }
        return null;
    }

    public function findByEmail(string $email): ?User {
        $userModel = UserModel::where('email', $email)->first();
        if ($userModel) {
            $user = new User($userModel->email, $userModel->name, $userModel->password, $userModel->department_id);
            $user->setId($userModel->id);
            return $user;
        }
        return null;
    }
}