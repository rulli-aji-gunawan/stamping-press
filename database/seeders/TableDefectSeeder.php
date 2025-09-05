<?php

namespace Database\Seeders;

use App\Models\TableDefect;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TableDefectSeeder extends Seeder
{
    // public function run(): void
    // {
    //     $downtimes = TableDefect::all();

    //     foreach ($downtimes as $dt) {
    //         $date = \Carbon\Carbon::parse($dt->date);
    //         $month = $date->month;
    //         $year = $date->year;

    //         $fyYear = ($month >= 4) ? $year : $year - 1;
    //         $fyMonth = ($month >= 4) ? ($month - 3) : ($month + 9);

    //         $dt->fy_n = "FY{$fyYear}-{$fyMonth}";
    //         $dt->save();
    //     }
    // }

    public function run(): void
    {
        $downtimes = TableDefect::all();

        foreach ($downtimes as $downtime) {
            $downtime->line = "Line-A";
            $downtime->save();
        }
    }
}
