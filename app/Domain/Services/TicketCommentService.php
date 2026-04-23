<?php

namespace App\Domain\Services;

use App\Domain\Entities\Ticket;
use App\Domain\Entities\TicketComment;
use App\Domain\Entities\User;
use App\Domain\Exceptions\UnauthorizedException;

class TicketCommentService
{
    public function addCommentToTicket(Ticket $ticket, User $user, string $commentText): TicketComment
    {
        if (!$ticket->canBeCommentedBy($user)) {
            throw new UnauthorizedException('User not authorized to comment on this ticket');
        }

        return new TicketComment($ticket->getId(), $user->getId(), $commentText);
    }
}
