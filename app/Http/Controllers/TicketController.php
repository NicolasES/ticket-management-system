<?php

namespace App\Http\Controllers;

use App\Application\DTOs\Input\CreateTicketCommentInput;
use App\Application\DTOs\Input\CreateTicketInput;
use App\Application\DTOs\Input\ListTicketsInput;
use App\Application\UseCases\CommentTicket;
use App\Application\UseCases\CreateTicket;
use App\Application\UseCases\ListTickets;
use App\Application\UseCases\GetTicketDetails;
use Illuminate\Http\Request;

class TicketController
{
    public function __construct(
        private readonly CreateTicket $createTicket,
        private readonly ListTickets $listTickets,
        private readonly CommentTicket $commentTicket,
        private readonly GetTicketDetails $getTicketDetails
    ) {}

    public function show(Request $request, int $ticketId)
    {
        $ticket = $this->getTicketDetails->execute($ticketId, $request->user()->id);

        return response()->json($ticket);
    }

    public function index(Request $request)
    {
        $user = $request->user();
        if (!$user->department_id) {
            return response()->json(['message' => 'User not associated with a department'], 400);
        }

        $input = new ListTicketsInput($user->department_id);
        $output = $this->listTickets->execute($input);

        return response()->json($output->tickets);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'departmentId' => 'required|integer',
        ]);

        $input = new CreateTicketInput(
            $request->input('title'),
            $request->input('description'),
            $request->input('departmentId'),
            $request->user()->id
        );

        $ticket = $this->createTicket->execute($input);

        return response()->json($ticket, 201);
    }

    public function addComment(Request $request, int $ticketId)
    {
        $request->validate([
            'comment' => 'required|string',
        ]);

        $input = new CreateTicketCommentInput(
            $ticketId,
            $request->user()->id,
            $request->input('comment')
        );

        $output = $this->commentTicket->execute($input);

        return response()->json($output, 201);
    }
}
