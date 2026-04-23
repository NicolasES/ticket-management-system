<?php

namespace App\Application\UseCases;

use App\Application\DAOs\TicketDAO;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Exceptions\UnauthorizedException;
use App\Domain\Repositories\TicketRepository;
use App\Domain\Repositories\UserRepository;

class GetTicketDetails
{
    public function __construct(
        private readonly TicketDAO $ticketDAO,
        private readonly TicketRepository $ticketRepository,
        private readonly UserRepository $userRepository
    ) {}

    public function execute(int $ticketId, int $userId): array
    {
        $user = $this->userRepository->findById($userId);
        if (!$user) {
            throw new NotFoundException('User not found');
        }

        $ticket = $this->ticketRepository->findById($ticketId);
        if (!$ticket) {
            throw new NotFoundException('Ticket not found');
        }

        if (!$ticket->canBeViewedBy($user)) {
            throw new UnauthorizedException('User not authorized to view this ticket');
        }

        $ticketDetails = $this->ticketDAO->getTicketDetails($ticketId);

        if (!$ticketDetails) {
            throw new NotFoundException('Ticket details not found');
        }

        return $ticketDetails;
    }
}
