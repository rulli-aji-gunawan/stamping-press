<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionProblem extends Model
{
    use HasFactory;

    protected $table = 'production_problems';

    protected $fillable = [
        'table_production_id',
        'reporter',
        'group',
        'date',
        'fy_n',
        'shift',
        'line',
        'model',
        'model_year',
        'item_name',
        'coil_no',
        'time_from',
        'time_until',
        'total_time',
        'process_name',
        'dt_category',
        'downtime_type',
        'dt_classification',
        'problem_description',
        'root_cause',
        'counter_measure',
        'pic',
        'status'
    ];

    // Relasi many-to-one dengan DataProduksi
    // public function dataProduksi()
    // {
    //     // return $this->belongsTo(InputProduction::class, 'input_production_id');
    //     return $this->belongsTo(TableProduction::class, 'table_production_id');
    // }
}
