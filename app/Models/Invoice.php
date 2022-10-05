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
        'invoiceID', 'client_id', 'date', 'paid', 'mark', 'file_invoice'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function services()
    {
        return $this->hasMany(Services::class, 'invoice_number', 'invoiceID');
    }

    function getFilePath() {
        return str_replace(['/', '\\'],DIRECTORY_SEPARATOR, storage_path('app/public/pdf').DIRECTORY_SEPARATOR.$this->file);
    }

}
