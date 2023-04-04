<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Services extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'invoice_number', 'vat_category', 'vat_amount', 'client_id', 'price', 'quantity', 'description'
    ];

    public function invoice()
    {
        return $this->belongsTo(Invoice::class, 'invoiceID');
    }
}
