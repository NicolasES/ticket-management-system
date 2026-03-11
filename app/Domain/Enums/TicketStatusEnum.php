<?php

namespace App\Domain\Enums;

enum TicketStatusEnum: string {
    case PENDING = 'pending';
    case IN_PROGRESS = 'in_progress';
    case COMPLETED = 'completed';
}