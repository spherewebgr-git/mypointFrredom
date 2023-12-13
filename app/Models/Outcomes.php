<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Outcomes extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'seira', 'outcome_number', 'shop', 'date', 'price', 'vat', 'file', 'status', 'invType',  'paymentMethod', 'mark'
    ];

    public function classifications()
    {
        return $this->hasMany(RetailClassification::class, 'outcome_hash', 'hashID');
    }

    public function foreignProvider()
    {
        return $this->hasOne(ForeignProviders::class,  'provider_vat', 'shop');
    }

    public function greekProvider()
    {
        return $this->hasOne(Provider::class,  'provider_vat', 'shop');
    }

    function getFilePath() {
        return str_replace(['/', '\\'],DIRECTORY_SEPARATOR, storage_path('app/public/files/outcomes').DIRECTORY_SEPARATOR.$this->file);
    }
}
