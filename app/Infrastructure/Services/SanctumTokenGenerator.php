<?php

namespace App\Infrastructure\Services;

use App\Application\Services\TokenGeneratorInterface;
use App\Domain\Entities\User as UserEntity;
use App\Models\User as UserModel;

class SanctumTokenGenerator implements TokenGeneratorInterface {
    public function generate(UserEntity $user): string {
        $model = UserModel::find($user->getId());
        if (!$model) {
            throw new \Exception('User not found');
        }
        return $model->createToken('auth_token')->plainTextToken;
    }
}
