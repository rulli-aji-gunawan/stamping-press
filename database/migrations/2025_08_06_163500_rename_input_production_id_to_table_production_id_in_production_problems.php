<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // 1. Migrasi data (jika belum dilakukan)
        DB::statement('UPDATE production_problems SET table_production_id = input_production_id WHERE table_production_id IS NULL');

        // 2. Drop foreign key constraint terlebih dahulu
        Schema::table('production_problems', function (Blueprint $table) {
            $table->dropForeign('production_problems_input_production_id_foreign');
        });

        // 3. Hapus kolom lama
        Schema::table('production_problems', function (Blueprint $table) {
            $table->dropColumn('input_production_id');
        });
    }
};
