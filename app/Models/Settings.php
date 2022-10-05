<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Settings extends Model
{
    use HasFactory;
    protected $fillable  = [
        'title',
        'company',
        'business',
        'address',
        'email',
        'phone',
        'mobile',
        'vat',
        'doy',
        'aade_user_id',
        'ocp_apim_subscription_key',
        'logo',
        'invoice_logo',
        'signature',
        'mail_account'
    ];
}
