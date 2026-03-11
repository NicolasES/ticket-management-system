<?php

namespace App\Application\DTOs\Output;

class TicketDepartmentOutput {
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}
}

class TicketRequesterOutput {
    public function __construct(
        public readonly int $id,
        public readonly string $name
    ) {}
}

class CreateTicketOutput {
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $description,
        public readonly string $status,
        public readonly TicketDepartmentOutput $department,
        public readonly TicketRequesterOutput $requester
    ) {}
}
