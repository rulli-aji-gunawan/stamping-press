<?php

namespace Database\Seeders;

use App\Models\TableDowntime;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TableDowntimeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $downtimes = TableDowntime::all();

        foreach ($downtimes as $downtime) {
            $downtime->line = "Line-A";
            $downtime->save();
        }
    }
}
