<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ForeignProviders extends Model
{
    use HasFactory;

    protected $fillable = [
        'provider_id', 'provider_name', 'address', 'address_number', 'address_tk', 'city', 'country', 'country_code', 'provider_vat', 'email', 'created_at', 'updated_at'
    ];
}
