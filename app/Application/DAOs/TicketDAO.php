<?php

namespace App\Application\DAOs;

interface TicketDAO
{
    /**
     * @param int $departmentId
     * @return array<int, array{id: int, title: string, description: string, requester_id: int, department_id: int, status: string, created_at: string}>
     */
    public function findByDepartmentId(int $departmentId): array;
}
