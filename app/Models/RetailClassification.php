<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RetailClassification extends Model
{
    use HasFactory;

    protected $fillable = [
        'hashID', 'outcome_hash', 'date', 'classification_category', 'classification_type',  'price', 'vat', 'service', 'description', 'mark', 'created_at', 'updated_at'
    ];

    public function outcomes()
    {
        return $this->belongsTo(Outcomes::class);
    }
}