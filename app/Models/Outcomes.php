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
        'outcome_number', 'shop', 'date', 'price', 'vat', 'file'
    ];

    function getFilePath() {
        return str_replace(['/', '\\'],DIRECTORY_SEPARATOR, storage_path('app/public/files/outcomes').DIRECTORY_SEPARATOR.$this->file);
    }
}
