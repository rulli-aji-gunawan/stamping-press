<?php

namespace Database\Seeders;

use App\Models\ProductionProblem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductionProblemSeeder extends Seeder
{
    public function run(): void
    {
        $downtimes = ProductionProblem::all();

        foreach ($downtimes as $dt) {
            $date = \Carbon\Carbon::parse($dt->date);
            $month = $date->month;
            $year = $date->year;

            $fyYear = ($month >= 4) ? $year : $year - 1;
            $fyMonth = ($month >= 4) ? ($month - 3) : ($month + 9);

            $dt->fy_n = "FY{$fyYear}-{$fyMonth}";
            $dt->save();
        }
    }
}
