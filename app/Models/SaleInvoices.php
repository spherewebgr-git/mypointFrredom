<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashID', 'sale_invoiceID', 'client_id', 'seira', 'date', 'paid', 'payment_method', 'mark'
    ];

    public function goods()
    {
        return $this->hasMany(Goods::class, 'sale_invoice_id', 'hashID');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
