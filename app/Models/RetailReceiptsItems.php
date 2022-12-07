<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailReceiptsItems extends Model
{
    use HasFactory;
    protected $fillable = [
        'retailHash', 'product_service', 'price', 'vat', 'vat_id', 'payment_method'
    ];

}
