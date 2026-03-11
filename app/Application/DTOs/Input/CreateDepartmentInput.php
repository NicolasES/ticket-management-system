<?php

namespace App\Application\DTOs\Input;

class CreateDepartmentInput {
    public function __construct(
        public readonly string $name
    ) {}    
}
