<?php

namespace App\Domain\Repositories;

use App\Domain\Entities\Ticket;

interface TicketRepository {
    public function save(Ticket $ticket): Ticket;
}