<?php

namespace App\Application\DTOs;

class CreateUserDTO {
    public function __construct(
        public readonly string $email,
        public readonly string $name
    ) {}
}