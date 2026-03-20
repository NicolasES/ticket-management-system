<?php

namespace App\Infrastructure\DAOs;

use App\Application\DAOs\TicketDAO as TicketDAOInterface;
use App\Models\TicketModel;

class TicketDAO implements TicketDAOInterface
{
    public function findByDepartmentId(int $departmentId): array
    {
        return TicketModel::where('department_id', $departmentId)
            ->get(['id', 'title', 'description', 'requester_id', 'department_id', 'status', 'created_at'])
            ->toArray();
    }
}
