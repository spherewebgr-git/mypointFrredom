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
        'code_number', 'name', 'company', 'work_title', 'email', 'mobile', 'price_balance', 'vat_balance', 'parakratisi_balance', 'phone', 'address', 'number', 'postal_code', 'city', 'vat', 'doy', 'mail_account', 'phone_account', 'company_logo', 'disabled'
    ];

    public function services()
    {
        return $this->hasMany(Services::class);
    }

    public function invoices()
    {
        return $this->hasMany(Invoice::class);
    }

    public function saleInvoices()
    {
        return $this->hasMany(SaleInvoices::class);
    }

    public function deliveryInvoices()
    {
        return $this->hasMany(DeliveryInvoices::class);
    }

    public function addresses()
    {
        return $this->hasMany(ClientAddresses::class,  'client_hash', 'hashID');
    }

    public static function getFilePath() {
        return str_replace(['/', '\\'],DIRECTORY_SEPARATOR, storage_path('app/public/files/clients/logos').DIRECTORY_SEPARATOR);
    }
}
