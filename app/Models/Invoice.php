<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Invoice extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'invoiceID', 'seira', 'client_id', 'date', 'paid', 'has_parakratisi',  'payment_method', 'mark', 'file_invoice'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }

    public function services()
    {
        return $this->hasMany(Services::class, 'invoice_number', 'hashID');
    }

    function getFilePath() {
        return str_replace(['/', '\\'],DIRECTORY_SEPARATOR, storage_path('app/public/pdf').DIRECTORY_SEPARATOR.$this->file);
    }

}
