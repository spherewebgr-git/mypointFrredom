<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HoldedProduct extends Model
{
    use HasFactory;
    protected $fillable = [
        'product_id', 'held_quantity', 'holded_by'
    ];
}
