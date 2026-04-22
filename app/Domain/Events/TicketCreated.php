<?php

namespace App\Domain\Events;

use App\Domain\Entities\Ticket;

class TicketCreated
{
    public function __construct(
        public readonly Ticket $ticket
    ) {}
}
