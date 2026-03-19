<?php

namespace App\Application\DTOs\Input;

class LoginUserInput {
    public function __construct(
        public readonly string $email,
        public readonly string $password
    ) {}
}
