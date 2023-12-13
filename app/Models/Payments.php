<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;

    protected $fillable = [
        'paymentHash', 'clientHash', 'payment_price', 'payment_date', 'bank', 'bank_code', 'description', 'bank_file'
    ];

    public function client()
    {
        return $this->hasOne(Client::class,  'hashID', 'clientHash');
    }

}
