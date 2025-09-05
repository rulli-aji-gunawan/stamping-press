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
        DB::statement('UPDATE table_defects SET table_production_id = input_production_id WHERE table_production_id IS NULL');

        // 2. Hapus kolom input_production_id (tanpa dropForeign)
        Schema::table('table_defects', function (Blueprint $table) {
            $table->dropColumn('input_production_id');
        });
    }

    public function down()
    {
        // Rollback: tambah kembali kolom input_production_id
        Schema::table('table_defects', function (Blueprint $table) {
            $table->unsignedBigInteger('input_production_id')->nullable()->after('id');
        });

        // Kembalikan data
        DB::statement('UPDATE table_defects SET input_production_id = table_production_id');

        // Hapus kolom baru
        Schema::table('table_defects', function (Blueprint $table) {
            $table->dropColumn('table_production_id');
        });
    }
};