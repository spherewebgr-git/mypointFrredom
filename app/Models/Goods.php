<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    protected $fillable = [
        'sale_invoice_id', 'client_id', 'price', 'quantity', 'description'
    ];

    public function saleInvoice()
    {
        return $this->belongsTo(SaleInvoices::class, 'sale_invoiceID');
    }
}
