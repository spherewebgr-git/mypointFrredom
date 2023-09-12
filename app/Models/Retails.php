<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Retails extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashID', 'invoiceType', 'retailID', 'date', 'seira', 'client_description', 'product_service', 'description', 'mark'
    ];

    protected $payment_method = [
        'method' => 'price'
    ];
    public function items()
    {
        return $this->hasMany(RetailReceiptsItems::class, 'retailHash', 'hashID');
    }

}

