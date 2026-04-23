<?php

namespace App\Application\UseCases;

use App\Application\DTOs\Input\CreateTicketCommentInput;
use App\Application\DTOs\Output\CreateTicketCommentOutput;
use App\Domain\Entities\TicketComment;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Repositories\TicketRepository;
use App\Domain\Repositories\UserRepository;
use App\Domain\Services\TicketCommentService;

class CommentTicket
{

    public function __construct(
        private TicketRepository $ticketRepository,
        private UserRepository $userRepository,
        private TicketCommentService $ticketCommentService
    ) {}

    public function execute(CreateTicketCommentInput $input) {
        $user = $this->userRepository->findById($input->userId);
        if (!$user) {
            throw new NotFoundException('User not found');
        }
        $ticket = $this->ticketRepository->findById($input->ticketId);
        if (!$ticket) {
            throw new NotFoundException('Ticket not found');
        }

        $comment = $this->ticketCommentService->addCommentToTicket($ticket, $user, $input->comment);
        $comment = $this->ticketRepository->addComment($ticket, $comment);

        return new CreateTicketCommentOutput(
            $comment->getId(),
            $comment->getTicketId(),
            $comment->getUserId(),
            $comment->getComment(),
            $comment->getCreatedAt()
        );
    }
}