<?php

namespace App\Application\UseCases;

use App\Application\DTOs\Input\CreateTicketInput;
use App\Application\DTOs\Output\CreateTicketOutput;
use App\Application\DTOs\Output\TicketDepartmentOutput;
use App\Application\DTOs\Output\TicketRequesterOutput;
use App\Domain\Entities\Ticket;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Repositories\DepartmentRepository;
use App\Domain\Repositories\TicketRepository;
use App\Domain\Repositories\UserRepository;

class CreateTicketUseCase {
    public function __construct(
        private readonly TicketRepository $ticketRepository,
        private readonly UserRepository $userRepository,
        private readonly DepartmentRepository $departmentRepository 
    ) {}

    public function execute(CreateTicketInput $input): CreateTicketOutput {
        $requester = $this->userRepository->findById($input->requesterId);
        if ($requester === null) {
            throw new NotFoundException('Requester not found');
        }
        $department = $this->departmentRepository->findById($input->departmentId);
        if ($department === null) {
            throw new NotFoundException('Department not found');
        }
        $ticket = new Ticket(
            $input->title,
            $input->description,
            $input->departmentId,
            $input->requesterId
        );

        $ticket = $this->ticketRepository->save($ticket);

        $output = new CreateTicketOutput(
            $ticket->getId(),
            $ticket->getTitle(),
            $ticket->getDescription(),
            new TicketDepartmentOutput($department->getId(), $department->getName()),
            new TicketRequesterOutput($requester->getId(), $requester->getName())
        );
        
        return $output;
    }
}