<?php

namespace App\Listeners;

use App\Domain\Events\TicketCreated;
use App\Mail\TicketRegistered;
use App\Domain\Repositories\DepartmentRepository;
use App\Domain\Repositories\UserRepository;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendTicketRegisteredEmail implements ShouldQueue
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly DepartmentRepository $departmentRepository
    ) {}

    public function handle(TicketCreated $event): void
    {
        $requester = $this->userRepository->findById($event->ticket->getRequesterId());
        $department = $this->departmentRepository->findById($event->ticket->getDepartmentId());

        if ($requester && $department) {
            Mail::to($requester->getEmail())
                ->send(new TicketRegistered($event->ticket, $department));
        }
    }
}
