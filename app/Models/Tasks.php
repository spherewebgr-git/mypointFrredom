<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tasks extends Model
{
    use HasFactory;

    protected $fillable  = [
        'taskName',
        'description',
        'client_id',
        'priority',
        'task_date',
        'completed',
        'created_at',
        'updated_at'
    ];
}
