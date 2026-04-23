<?php

namespace App\Domain\Entities;

use App\Domain\Enums\TicketStatusEnum;
use DateTimeImmutable;
use DateTimeZone;

class Ticket {
    private ?int $id = null;
    private string $title;
    private string $description;
    private int $departmentId;
    private int $requesterId;
    private DateTimeImmutable $createdAt;
    private TicketStatusEnum $status;

    public function __construct(string $title, string $description, int $departmentId, int $requesterId) {
        $this->title = $title;
        $this->description = $description;
        $this->departmentId = $departmentId;
        $this->requesterId = $requesterId;
        $this->createdAt = new DateTimeImmutable('now', new DateTimeZone('UTC'));
        $this->status = TicketStatusEnum::PENDING;
    }

    public function getId(): ?int {
        return $this->id;
    }

    public function setId(int $id): void {
        $this->id = $id;
    }

    public function getTitle(): string {
        return $this->title;
    }

    public function getDescription(): string {
        return $this->description;
    }

    public function getDepartmentId(): int {
        return $this->departmentId;
    }

    public function getRequesterId(): int {
        return $this->requesterId;
    }

    public function getCreatedAt(): DateTimeImmutable {
        return $this->createdAt;
    }

    public function getStatus(): TicketStatusEnum {
        return $this->status;
    }

    public function canBeCommentedBy(User $user): bool {
        return $this->requesterId == $user->getId() || $this->departmentId == $user->getDepartmentId();
    }

    public function canBeViewedBy(User $user): bool {
        return $this->requesterId == $user->getId() || $this->departmentId == $user->getDepartmentId();
    }
}