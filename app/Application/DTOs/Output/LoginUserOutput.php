<?php

namespace App\Application\DTOs\Output;

use App\Domain\Entities\User;

class LoginUserOutput {
    public readonly array $user;
    public readonly string $access_token;
    public readonly string $token_type;

    public function __construct(User $user, string $token) {
        $this->user = [
            'id' => $user->getId(),
            'name' => $user->getName(),
            'email' => $user->getEmail(),
        ];
        $this->access_token = $token;
        $this->token_type = 'Bearer';
    }
}
