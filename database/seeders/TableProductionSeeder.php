<?php

namespace Database\Seeders;

use App\Models\TableProduction;
use Illuminate\Database\Seeder;

class TableProductionSeeder extends Seeder
{
    public function run(): void
    {
        $productions = TableProduction::all();

        foreach ($productions as $prod) {

            $prod->line = "Line-A";
            $prod->save();
        }
    }
}
