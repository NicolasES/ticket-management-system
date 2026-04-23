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

test('should allow requester to comment on ticket', function() {
    $ticket = new Ticket('title', 'description', 10, 5);
    $requester = new \App\Domain\Entities\User('name', 'email', 'pass', 99);
    $requester->setId(5);
    
    expect($ticket->canBeCommentedBy($requester))->toBeTrue();
});

test('should allow user from same department to comment on ticket', function() {
    $ticket = new Ticket('title', 'description', 10, 5); 
    $deptUser = new \App\Domain\Entities\User('name', 'email', 'pass', 10); 
    $deptUser->setId(8);
    
    expect($ticket->canBeCommentedBy($deptUser))->toBeTrue();
});

test('should not allow random user to comment on ticket', function() {
    $ticket = new Ticket('title', 'description', 10, 5); 
    $randomUser = new \App\Domain\Entities\User('name', 'email', 'pass', 99); 
    $randomUser->setId(8);
    
    expect($ticket->canBeCommentedBy($randomUser))->toBeFalse();
});