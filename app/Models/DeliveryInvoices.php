<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveryInvoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashID', 'delivery_invoice_id', 'client_id', 'seira', 'date', 'paid', 'price', 'vat', 'final', 'payment_method', 'mark', 'file_invoice'
    ];

    public function goods()
    {
        return $this->belongsToMany(Goods::class, 'delivered_goods', 'delivery_invoice_id', 'delivered_good_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
