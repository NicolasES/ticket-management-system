<?php

use App\Domain\Entities\Ticket;

test('can create a ticket', function () {
    $ticket = new Ticket('title', 'description', 1, 1);
    expect($ticket->getTitle())->toBe('title');
    expect($ticket->getDescription())->toBe('description');
    expect($ticket->getDepartmentId())->toBe(1);
    expect($ticket->getRequesterId())->toBe(1);
    expect($ticket->getCreatedAt())->toBeInstanceOf(DateTimeImmutable::class);
});