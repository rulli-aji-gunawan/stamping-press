<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DowntimeClassification extends Model
{
    use HasFactory;
    protected $fillable = [
        'downtime_classification'
    ];
}
