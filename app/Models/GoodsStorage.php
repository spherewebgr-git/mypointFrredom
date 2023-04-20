<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoodsStorage extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'quantity',
        'held_quantity',
        'held_by'
    ];

    public function goods()
    {
        return $this->belongsTo(Goods::class, 'id');
    }
}
