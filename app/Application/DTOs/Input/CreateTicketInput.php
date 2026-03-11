<?php

namespace App\Application\DTOs\Input;

class CreateTicketInput {
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly int $departmentId,
        public readonly int $requesterId
    ) {}
}
