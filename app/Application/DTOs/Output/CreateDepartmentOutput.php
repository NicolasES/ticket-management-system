<?php

namespace App\Application\DTOs\Output;

class CreateDepartmentOutput {
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}
}