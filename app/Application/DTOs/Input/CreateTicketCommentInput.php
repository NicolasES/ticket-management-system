<?php

namespace App\Application\DTOs\Input;

class CreateTicketCommentInput {
    public function __construct(
        public readonly int $ticketId,
        public readonly int $userId,
        public readonly string $comment
    ) {}
}
