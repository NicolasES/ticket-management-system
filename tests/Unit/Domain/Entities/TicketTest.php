<?php

use App\Domain\Entities\Ticket;
use App\Domain\Enums\TicketStatusEnum;

test('should create a ticket', function () {
    $ticket = new Ticket('title', 'description', 1, 1);
    expect($ticket->getTitle())->toBe('title');
    expect($ticket->getDescription())->toBe('description');
    expect($ticket->getDepartmentId())->toBe(1);
    expect($ticket->getRequesterId())->toBe(1);
    expect($ticket->getCreatedAt())->toBeInstanceOf(DateTimeImmutable::class);
    expect($ticket->getStatus())->toBeInstanceOf(TicketStatusEnum::class);
    expect($ticket->getStatus()->value)->toEqual(TicketStatusEnum::PENDING->value);
});

test('should set the id of a ticket', function() {
    $ticket = new Ticket('title', 'description', 1, 1);
    $ticket->setId(1);
    expect($ticket->getId())->toBe(1);
});