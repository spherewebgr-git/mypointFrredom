<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SaleInvoices extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashID', 'sale_invoiceID', 'seira', 'date', 'paid', 'payment_method', 'mark'
    ];

    public function goods()
    {
        return $this->hasMany(Goods::class, 'sale_invoice_id', 'hashID');
    }
}
