<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Nonaktifkan pengecekan foreign key constraints sementara
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        DB::table('input_productions')->truncate();
        DB::table('production_problems')->truncate();

        // Aktifkan kembali pengecekan foreign key constraints
        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
