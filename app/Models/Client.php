<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Client extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'name', 'company', 'work_title', 'email', 'mobile', 'phone', 'address', 'number', 'postal_code', 'city', 'vat', 'doy', 'mail_account', 'phone_account', 'company_logo', 'disabled'
    ];

    public function invoices()
    {
        return $this->hasMany(Services::class);
    }

    public static function getFilePath() {
        return str_replace(['/', '\\'],DIRECTORY_SEPARATOR, storage_path('app/public/files/clients/logos').DIRECTORY_SEPARATOR);
    }
}
