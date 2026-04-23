<?php

namespace App\Infrastructure\Persistence;

use App\Domain\Repositories\TicketRepository as TicketRepositoryInterface;
use App\Domain\Entities\Ticket;
use App\Models\TicketModel;

use App\Domain\Entities\TicketComment;
use App\Models\TicketCommentModel;

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

    public function findById(int $id): ?Ticket {
        $model = TicketModel::find($id);
        if (!$model) return null;

        $ticket = new Ticket(
            $model->title,
            $model->description,
            $model->department_id,
            $model->requester_id
        );
        $ticket->setId($model->id);
        return $ticket;
    }

    public function addComment(Ticket $ticket, TicketComment $comment): TicketComment {
        $commentModel = TicketCommentModel::create([
            'ticket_id' => $comment->getTicketId(),
            'user_id' => $comment->getUserId(),
            'comment' => $comment->getComment(),
        ]);

        $comment->setId($commentModel->id);

        return $comment;
    }
}