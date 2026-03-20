<?php

namespace App\Application\UseCases;

use App\Application\DTOs\Input\ListTicketsInput;
use App\Application\DTOs\Output\ListTicketsOutput;
use App\Application\DAOs\TicketDAO;

class ListTickets {
    public function __construct(
        private TicketDAO $ticketDAO
    ) {}

    public function execute(ListTicketsInput $input): ListTicketsOutput {
        $tickets = $this->ticketDAO->findByDepartmentId($input->departmentId);

        $formattedTickets = array_map(function ($ticket) {
            return [
                'id' => $ticket['id'],
                'title' => $ticket['title'],
                'description' => $ticket['description'],
                'requesterId' => $ticket['requester_id'],
                'departmentId' => $ticket['department_id'],
                'status' => $ticket['status'] ?? 'pending',
                'createdAt' => $ticket['created_at'] ?? '',
            ];
        }, $tickets);

        return new ListTicketsOutput($formattedTickets);
    }
}
