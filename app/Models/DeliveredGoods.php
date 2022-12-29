<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DeliveredGoods extends Model
{
    use HasFactory;

    protected $fillable = [
        'invoice_hash',
        'delivery_type',
        'delivered_good_id',
        'quantity',
        'price',
        'line_vat',
        'line_final_price',
        'created_at',
        'updated_at',

    ];

    public function deliveryInvoice()
    {
        return $this->belongsTo(DeliveryInvoices::class, 'hashID');
    }
}
