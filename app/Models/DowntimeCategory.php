<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DowntimeCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'downtime_name',
        'downtime_type',
    ];
}
