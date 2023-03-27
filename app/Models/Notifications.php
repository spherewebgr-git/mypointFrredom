<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashID', 'notification_type', 'notification_action', 'client_hash', 'client_email', 'last_notified_at', 'status'
    ];
}
