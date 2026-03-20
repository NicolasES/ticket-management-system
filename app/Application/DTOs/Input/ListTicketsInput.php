<?php

namespace App\Application\DTOs\Input;

class ListTicketsInput {
    public function __construct(
        public readonly int $departmentId
    ) {}
}
