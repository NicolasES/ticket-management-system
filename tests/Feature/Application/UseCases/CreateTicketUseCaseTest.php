<?php

use App\Application\DTOs\Input\CreateTicketInput;
use App\Application\DTOs\Output\CreateTicketOutput;
use App\Application\UseCases\CreateTicketUseCase;
use App\Domain\Entities\Department;
use App\Domain\Entities\Ticket;
use App\Domain\Entities\User;
use App\Domain\Exceptions\NotFoundException;
use App\Domain\Repositories\DepartmentRepository;
use App\Domain\Repositories\TicketRepository;
use App\Domain\Repositories\UserRepository;

describe('AnswerQuestion', function () {
    beforeEach(function () {
        $this->userMock = Mockery::mock(User::class);
        $this->departmentMock = Mockery::mock(Department::class);

        $this->userMock->shouldReceive('getId')->andReturn(123);
        $this->userMock->shouldReceive('getName')->andReturn('fakeRequesterName');
        $this->departmentMock->shouldReceive('getId')->andReturn(123);
        $this->departmentMock->shouldReceive('getName')->andReturn('fakeDepartmentName');
    });


    test('should create a new ticket', function () {
        $ticketRepository = Mockery::mock(TicketRepository::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $departmentRepository = Mockery::mock(DepartmentRepository::class);
        
        $ticket = Mockery::mock(Ticket::class);
        $ticket->shouldReceive('getId')->andReturn(123);
        $ticket->shouldReceive('getTitle')->andReturn('fakeTitle');
        $ticket->shouldReceive('getDescription')->andReturn('fakeDescription');

        $userRepository->shouldReceive('findById')->andReturn($this->userMock);
        $departmentRepository->shouldReceive('findById')->andReturn($this->departmentMock);
        
        $ticketRepository->shouldReceive('save')->andReturn($ticket);
        
        $createTicketUseCase = new CreateTicketUseCase($ticketRepository, $userRepository, $departmentRepository);
        $createTicketInput = new CreateTicketInput('fakeTitle', 'fakeDescription', 1, 1);
        $output = $createTicketUseCase->execute($createTicketInput);
        
        expect($output)->toBeInstanceOf(CreateTicketOutput::class);
        expect($output->id)->toBe(123);
        expect($output->title)->toBe('fakeTitle');
        expect($output->description)->toBe('fakeDescription');
        expect($output->department->name)->toBe('fakeDepartmentName');
        expect($output->requester->name)->toBe('fakeRequesterName');
    });

    test('should throw an Excpetion with requester not found', function () {
        $ticketRepository = Mockery::mock(TicketRepository::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $departmentRepository = Mockery::mock(DepartmentRepository::class);
        $ticket = Mockery::mock(Ticket::class);
        
        $userRepository->shouldReceive('findById')->andReturn(null);
        $departmentRepository->shouldReceive('findById')->andReturn($this->departmentMock);
        $ticketRepository->shouldReceive('save')->andReturn($ticket);
        
        $createTicketUseCase = new CreateTicketUseCase($ticketRepository, $userRepository, $departmentRepository);
        $createTicketInput = new CreateTicketInput('fakeTitle', 'fakeDescription', 1, 1);
        expect(fn() => $createTicketUseCase->execute($createTicketInput))->toThrow(new NotFoundException('Requester not found'));
    });

    test('should throw an Excpetion with department not found', function () {
        $ticketRepository = Mockery::mock(TicketRepository::class);
        $userRepository = Mockery::mock(UserRepository::class);
        $departmentRepository = Mockery::mock(DepartmentRepository::class);
        $ticket = Mockery::mock(Ticket::class);
        
        $userRepository->shouldReceive('findById')->andReturn($this->userMock);
        $departmentRepository->shouldReceive('findById')->andReturn(null);
        $ticketRepository->shouldReceive('save')->andReturn($ticket);
        
        $createTicketUseCase = new CreateTicketUseCase($ticketRepository, $userRepository, $departmentRepository);
        $createTicketInput = new CreateTicketInput('fakeTitle', 'fakeDescription', 1, 1);
        expect(fn() => $createTicketUseCase->execute($createTicketInput))->toThrow(new NotFoundException('Department not found'));
    });

});