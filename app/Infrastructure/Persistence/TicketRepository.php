<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Repositories\TicketRepository as TicketRepositoryInterface;
use App\Domain\Entities\Ticket;
use App\Models\TicketModel;

class TicketRepository implements TicketRepositoryInterface {
    public function save(Ticket $ticket): Ticket {
        $ticketModel = TicketModel::create([
            'title' => $ticket->getTitle(),
            'description' => $ticket->getDescription(),
            'department_id' => $ticket->getDepartmentId(),
            'requester_id' => $ticket->getRequesterId(),
        ]);
        $ticket->setId($ticketModel->id);
        return $ticket;
    }
}