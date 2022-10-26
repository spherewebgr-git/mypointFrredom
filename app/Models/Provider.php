<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Provider extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id', 'provider_name', 'address', 'address_number', 'address_tk', 'city', 'provider_vat', 'provider_doy', 'email', 'phone', 'created_at', 'updated_at'
    ];
}
