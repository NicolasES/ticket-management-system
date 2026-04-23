<?php

namespace Tests\Unit\Application\UseCases;

use App\Application\DAOs\TicketDAO;
use App\Application\UseCases\GetTicketDetails;
use App\Domain\Entities\Ticket;
use App\Domain\Entities\User;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Exceptions\UnauthorizedException;
use App\Domain\Repositories\TicketRepository;
use App\Domain\Repositories\UserRepository;
use PHPUnit\Framework\TestCase;

class GetTicketDetailsTest extends TestCase
{
    private $ticketDAO;
    private $ticketRepository;
    private $userRepository;
    private $useCase;

    protected function setUp(): void
    {
        parent::setUp();
        
        $this->ticketDAO = \Mockery::mock(TicketDAO::class);
        $this->ticketRepository = \Mockery::mock(TicketRepository::class);
        $this->userRepository = \Mockery::mock(UserRepository::class);
        
        $this->useCase = new GetTicketDetails(
            $this->ticketDAO,
            $this->ticketRepository,
            $this->userRepository
        );
    }

    protected function tearDown(): void
    {
        \Mockery::close();
        parent::tearDown();
    }

    public function test_should_return_ticket_details_if_authorized()
    {
        $userId = 1;
        $ticketId = 1;

        $user = new User('Test User', 'test@example.com', 'password', 10);
        $user->setId($userId);

        $ticket = new Ticket('Title', 'Description', 10, 2); // Same department
        $ticket->setId($ticketId);

        $expectedDetails = ['id' => $ticketId, 'title' => 'Title'];

        $this->userRepository->shouldReceive('findById')->with($userId)->once()->andReturn($user);
        $this->ticketRepository->shouldReceive('findById')->with($ticketId)->once()->andReturn($ticket);
        $this->ticketDAO->shouldReceive('getTicketDetails')->with($ticketId)->once()->andReturn($expectedDetails);

        $result = $this->useCase->execute($ticketId, $userId);

        $this->assertEquals($expectedDetails, $result);
    }

    public function test_should_throw_exception_if_user_not_authorized()
    {
        $userId = 1;
        $ticketId = 1;

        $user = new User('Test User', 'test@example.com', 'password', 10);
        $user->setId($userId);

        $ticket = new Ticket('Title', 'Description', 20, 2); // Different department, different user
        $ticket->setId($ticketId);

        $this->userRepository->shouldReceive('findById')->with($userId)->once()->andReturn($user);
        $this->ticketRepository->shouldReceive('findById')->with($ticketId)->once()->andReturn($ticket);

        $this->expectException(UnauthorizedException::class);
        $this->expectExceptionMessage('User not authorized to view this ticket');

        $this->useCase->execute($ticketId, $userId);
    }

    public function test_should_throw_exception_if_ticket_not_found()
    {
        $userId = 1;
        $ticketId = 1;

        $user = new User('Test User', 'test@example.com', 'password', 10);
        $user->setId($userId);

        $this->userRepository->shouldReceive('findById')->with($userId)->once()->andReturn($user);
        $this->ticketRepository->shouldReceive('findById')->with($ticketId)->once()->andReturnNull();

        $this->expectException(NotFoundException::class);
        $this->expectExceptionMessage('Ticket not found');

        $this->useCase->execute($ticketId, $userId);
    }
}
