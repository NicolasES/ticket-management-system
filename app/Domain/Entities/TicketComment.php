<?php

namespace App\Domain\Entities;

use App\Domain\Exceptions\DomainException;

class TicketComment
{
    private ?int $id = null;
    private int $ticketId;
    private int $userId;
    private string $comment;
    private \DateTimeImmutable $createdAt;

    public function __construct(
        int $ticketId,
        int $userId,
        string $comment
    ) {
        $this->ticketId = $ticketId;
        $this->userId = $userId;
        $this->setComment($comment);
        $this->createdAt = new \DateTimeImmutable('now', new \DateTimeZone('UTC'));    
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getTicketId(): int {
        return $this->ticketId;
    }

    public function getUserId(): int {
        return $this->userId;
    }

    public function getComment(): string {
        return $this->comment;
    }

    public function setComment(string $comment): void {
        if (empty($comment)) {
            throw new DomainException('Comment cannot be empty');
        }
        $this->comment = $comment;
    }

    public function getCreatedAt(): \DateTimeImmutable {
        return $this->createdAt;
    }
}