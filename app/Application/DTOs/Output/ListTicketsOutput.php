<?php

namespace App\Application\DTOs\Output;

class ListTicketsOutput {
    /**
     * @param array<int, array{id: int, title: string, description: string, requesterId: int, departmentId: int, status: string, createdAt: string}> $tickets
     */
    public function __construct(
        public readonly array $tickets
    ) {}
}
