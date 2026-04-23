<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Ticket;
use App\Domain\Entities\TicketComment;

interface TicketRepository
{
    public function save(Ticket $ticket): Ticket;
    public function findById(int $id): ?Ticket;
    public function addComment(Ticket $ticket, TicketComment $comment): TicketComment;
}