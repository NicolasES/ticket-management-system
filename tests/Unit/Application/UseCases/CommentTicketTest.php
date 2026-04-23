<?php

use App\Application\DTOs\Input\CreateTicketCommentInput;
use App\Application\DTOs\Output\CreateTicketCommentOutput;
use App\Application\UseCases\CommentTicket;
use App\Domain\Entities\Ticket;
use App\Domain\Entities\TicketComment;
use App\Domain\Entities\User;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Repositories\TicketRepository;
use App\Domain\Repositories\UserRepository;
use App\Domain\Services\TicketCommentService;

afterEach(function () {
    Mockery::close();
});

test('should successfully comment on ticket', function () {
    $ticketRepo = Mockery::mock(TicketRepository::class);
    $userRepo = Mockery::mock(UserRepository::class);
    $service = new TicketCommentService();

    $user = new User('name', 'email', 'pass', 1);
    $user->setId(1);
    
    $ticket = new Ticket('title', 'desc', 1, 1);
    $ticket->setId(10);

    $userRepo->shouldReceive('findById')->with(1)->andReturn($user);
    $ticketRepo->shouldReceive('findById')->with(10)->andReturn($ticket);
    
    // Simula o retorno do repositório
    $savedComment = new TicketComment(10, 1, 'Hello');
    
    // Usa reflection para setar o ID privado, como um repositório real faria
    $reflection = new ReflectionClass($savedComment);
    $property = $reflection->getProperty('id');
    $property->setAccessible(true);
    $property->setValue($savedComment, 99);

    $ticketRepo->shouldReceive('addComment')->once()->andReturn($savedComment);

    $useCase = new CommentTicket($ticketRepo, $userRepo, $service);
    $input = new CreateTicketCommentInput(10, 1, 'Hello');
    
    $output = $useCase->execute($input);

    expect($output)->toBeInstanceOf(CreateTicketCommentOutput::class);
    expect($output->comment)->toBe('Hello');
    expect($output->ticketId)->toBe(10);
});

test('should throw exception if user not found', function () {
    $ticketRepo = Mockery::mock(TicketRepository::class);
    $userRepo = Mockery::mock(UserRepository::class);
    $service = new TicketCommentService();

    $userRepo->shouldReceive('findById')->with(1)->andReturn(null);

    $useCase = new CommentTicket($ticketRepo, $userRepo, $service);
    $input = new CreateTicketCommentInput(10, 1, 'Hello');
    
    $useCase->execute($input);
})->throws(NotFoundException::class, 'User not found');

test('should throw exception if ticket not found', function () {
    $ticketRepo = Mockery::mock(TicketRepository::class);
    $userRepo = Mockery::mock(UserRepository::class);
    $service = new TicketCommentService();

    $user = new User('name', 'email', 'pass', 1);
    $userRepo->shouldReceive('findById')->with(1)->andReturn($user);
    $ticketRepo->shouldReceive('findById')->with(10)->andReturn(null);

    $useCase = new CommentTicket($ticketRepo, $userRepo, $service);
    $input = new CreateTicketCommentInput(10, 1, 'Hello');
    
    $useCase->execute($input);
})->throws(NotFoundException::class, 'Ticket not found');
