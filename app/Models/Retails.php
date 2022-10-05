<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retails extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashID', 'retailID', 'date', 'seira', 'price', 'vat', 'service', 'description', 'mark'
    ];
}
