<?php

namespace App\Http\Controllers;

use App\Application\DTOs\Input\CreateTicketInput;
use App\Application\UseCases\CreateTicket;
use Illuminate\Http\Request;

class TicketController
{
    public function __construct(
        private readonly CreateTicket $createTicket
    ) {}

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
}
