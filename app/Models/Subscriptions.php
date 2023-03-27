<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscriptions extends Model
{
    use HasFactory;

    protected $fillable  = [
        'client_hash',
        'hashID',
        'subscription_number',
        'service_title',
        'service_type',
        'service_domain',
        'first_payment',
        'service_duration',
        'active_subscription',
        'last_payed',
        'duration_price',
        'client_notified',
        'client_notified_at',
        'created_at',
        'updated_at',

    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_hash', 'hashID');
    }

    public function notifications()
    {
        return $this->hasMany(Notifications::class);
    }
}
