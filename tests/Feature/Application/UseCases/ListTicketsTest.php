<?php

namespace Tests\Feature\Application\UseCases;

use App\Application\DTOs\Input\ListTicketsInput;
use App\Application\UseCases\ListTickets;
use App\Application\DAOs\TicketDAO;
use Mockery;
use Tests\TestCase;

class ListTicketsTest extends TestCase {
    public function test_should_list_tickets_by_department_id() {
        // Arrange
        $departmentId = 1;
        $ticketsData = [
            [
                'id' => 10,
                'title' => 'Ticket 1',
                'description' => 'Desc 1',
                'requester_id' => 1,
                'department_id' => 1,
                'status' => 'pending',
                'created_at' => '2023-01-01 10:00:00'
            ],
            [
                'id' => 11,
                'title' => 'Ticket 2',
                'description' => 'Desc 2',
                'requester_id' => 2,
                'department_id' => 1,
                'status' => 'open',
                'created_at' => '2023-01-01 11:00:00'
            ]
        ];

        $ticketDAO = Mockery::mock(TicketDAO::class);
        $ticketDAO->shouldReceive('findByDepartmentId')
            ->once()
            ->with($departmentId)
            ->andReturn($ticketsData);

        $useCase = new ListTickets($ticketDAO);
        $input = new ListTicketsInput($departmentId);

        // Act
        $output = $useCase->execute($input);

        // Assert
        $this->assertCount(2, $output->tickets);
        $this->assertEquals(10, $output->tickets[0]['id']);
        $this->assertEquals('Ticket 1', $output->tickets[0]['title']);
        $this->assertEquals(11, $output->tickets[1]['id']);
        $this->assertEquals('Ticket 2', $output->tickets[1]['title']);
    }

    protected function tearDown(): void {
        Mockery::close();
        parent::tearDown();
    }
}
