<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryInvoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashID', 'delivery_invoice_id', 'client_id', 'seira', 'sendFrom', 'sendTo', 'date', 'paid', 'payment_method', 'mark', 'file_invoice'
    ];

    public function deliveredGoods()
    {
        return $this->hasMany(DeliveredGoods::class, 'invoice_hash', 'hashID');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
