<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_number', 'product_name', 'product_vat_id', 'price', 'quantity', 'product_description'
    ];

    public function saleInvoice()
    {
        return $this->belongsTo(SaleInvoices::class, 'sale_invoiceID');
    }

    public function deliveryInvoices()
    {
        return $this->belongsToMany(DeliveryInvoices::class);
    }
}
