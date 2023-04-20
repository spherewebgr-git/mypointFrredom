<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Goods extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_number',
        'product_name',
        'product_description',
        'barcode',
        'product_image',
        'product_type',
        'mm_type',
        'product_vat_id',
        'product_category',
        'price',
        'vat_price',
        'wholesale_price',
        'discount_price'

    ];

    public function saleInvoice()
    {
        return $this->belongsTo(SaleInvoices::class, 'sale_invoiceID');
    }

    public function deliveryInvoices()
    {
        return $this->belongsToMany(DeliveryInvoices::class);
    }

    public function storage()
    {
        return $this->hasOne(GoodsStorage::class, 'product_id', 'product_number');
    }

    public function holds()
    {
        return $this->hasMany(HoldedProduct::class, 'product_id', 'id');
    }
}
