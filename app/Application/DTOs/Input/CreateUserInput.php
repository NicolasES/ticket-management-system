<?php

namespace App\Application\DTOs\Input;

class CreateUserInput{
    public function __construct(
        public readonly string $email,
        public readonly string $name
    ) {}
}