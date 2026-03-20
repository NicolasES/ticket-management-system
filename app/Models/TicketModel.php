<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketModel extends Model {
    protected $table = 'tickets';
    protected $fillable = [
        'department_id',
        'requester_id',
        'title',
        'description',
    ];
}