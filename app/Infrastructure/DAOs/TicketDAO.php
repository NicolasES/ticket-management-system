<?php

namespace App\Infrastructure\DAOs;

use App\Application\DAOs\TicketDAO as TicketDAOInterface;
use App\Models\TicketModel;
use Illuminate\Support\Facades\DB;

class TicketDAO implements TicketDAOInterface
{
    public function findByDepartmentId(int $departmentId): array
    {
        return TicketModel::where('department_id', $departmentId)
            ->get(['id', 'title', 'description', 'requester_id', 'department_id', 'status', 'created_at'])
            ->toArray();
    }

    public function getTicketDetails(int $ticketId): ?array
    {
        $ticket = DB::table('tickets')
            ->join('users as creator', 'tickets.requester_id', '=', 'creator.id')
            ->select(
                'tickets.id',
                'tickets.title',
                'tickets.description',
                'tickets.status',
                'tickets.created_at',
                'tickets.department_id',
                'tickets.requester_id',
                'creator.name as creator_name',
                'creator.email as creator_email'
            )
            ->where('tickets.id', $ticketId)
            ->first();

        if (!$ticket) {
            return null;
        }

        $comments = DB::table('ticket_comments')
            ->join('users', 'ticket_comments.user_id', '=', 'users.id')
            ->join('departments', 'users.department_id', '=', 'departments.id')
            ->select(
                'ticket_comments.id',
                'ticket_comments.comment as content',
                'ticket_comments.created_at',
                'ticket_comments.user_id',
                'users.name as user_name',
                'departments.name as department_name'
            )
            ->where('ticket_comments.ticket_id', $ticketId)
            ->orderBy('ticket_comments.created_at', 'asc')
            ->get()
            ->map(function ($comment) use ($ticket) {
                $type = ($comment->user_id === $ticket->requester_id) ? 'user' : 'response';
                
                return [
                    'id' => $comment->id,
                    'user' => [
                        'name' => $comment->user_name,
                        'department' => $comment->department_name,
                    ],
                    'content' => $comment->content,
                    'created_at' => $comment->created_at,
                    'type' => $type
                ];
            })->toArray();

        return [
            'id' => $ticket->id,
            'title' => $ticket->title,
            'description' => $ticket->description,
            'status' => $ticket->status,
            'createdAt' => $ticket->created_at,
            'departmentId' => $ticket->department_id,
            'creator' => [
                'name' => $ticket->creator_name,
                'email' => $ticket->creator_email,
            ],
            'interactions' => $comments,
        ];
    }
}
