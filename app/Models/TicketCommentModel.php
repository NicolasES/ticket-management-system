<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TicketCommentModel extends Model {
    protected $table = 'ticket_comments';
    protected $fillable = [
        'ticket_id',
        'user_id',
        'comment',
    ];
}
