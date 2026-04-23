<?php

namespace App\Application\DTOs\Output;

class CreateTicketCommentOutput {
    public function __construct(
        public readonly int $id,
        public readonly int $ticketId,
        public readonly int $userId,
        public readonly string $comment,
        public readonly \DateTimeImmutable $createdAt
    ) {}
}
