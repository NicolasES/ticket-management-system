<?php

use App\Domain\Entities\Ticket;
use App\Domain\Entities\User;
use App\Domain\Entities\TicketComment;
use App\Domain\Services\TicketCommentService;
use App\Domain\Exceptions\UnauthorizedException;

test('should add comment when user is authorized', function () {
    $ticket = new Ticket('title', 'desc', 1, 1);
    $ticket->setId(10);
    $user = new User('name', 'email', 'pass', 1);
    $user->setId(1);

    $service = new TicketCommentService();
    $comment = $service->addCommentToTicket($ticket, $user, 'My comment');

    expect($comment)->toBeInstanceOf(TicketComment::class);
    expect($comment->getComment())->toBe('My comment');
});

test('should throw exception when user is not authorized to comment', function () {
    $ticket = new Ticket('title', 'desc', 1, 1);
    $ticket->setId(10);
    $user = new User('name', 'email', 'pass', 2); // Outro departamento
    $user->setId(2); // Outro usuário

    $service = new TicketCommentService();
    $service->addCommentToTicket($ticket, $user, 'My comment');
})->throws(UnauthorizedException::class);
