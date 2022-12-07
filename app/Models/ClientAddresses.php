<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientAddresses extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'client_hash', 'address', 'address_type', 'address_name', 'number', 'city', 'postal_code'
    ];


    public function client()
    {
        return $this->belongsTo(Client::class, 'hashID');
    }
}
