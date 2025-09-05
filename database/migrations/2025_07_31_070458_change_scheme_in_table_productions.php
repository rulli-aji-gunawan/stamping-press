<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('table_productions', function (Blueprint $table) {
            // Rename kolom jika masih item_id
            if (Schema::hasColumn('table_productions', 'item_id')) {
                $table->renameColumn('item_id', 'item_name');
            }
            // Tambahkan/ubah kolom agar sama dengan input_productions
            $table->string('reporter', 50)->nullable()->change();
            $table->string('group', 10)->nullable()->change();
            $table->date('date')->nullable()->change();
            $table->string('shift', 10)->nullable()->change();
            $table->time('start_time')->nullable()->change();
            $table->time('finish_time')->nullable()->change();
            $table->string('total_prod_time', 10)->nullable()->change();
            $table->string('model', 20)->nullable()->change();
            $table->string('model_year', 10)->nullable()->change();
            $table->decimal('spm', 8, 2)->nullable()->change();
            $table->string('item_name', 100)->nullable()->change();
            $table->string('coil_no', 20)->nullable()->change();
            $table->integer('plan_a')->nullable()->change();
            $table->integer('plan_b')->nullable()->change();
            $table->integer('ok_a')->nullable()->change();
            $table->integer('ok_b')->nullable()->change();
            $table->integer('rework_a')->nullable()->change();
            $table->integer('rework_b')->nullable()->change();
            $table->integer('scrap_a')->nullable()->change();
            $table->integer('scrap_b')->nullable()->change();
            $table->integer('sample_a')->nullable()->change();
            $table->integer('sample_b')->nullable()->change();
            $table->string('rework_exp', 255)->nullable()->change();
            $table->string('scrap_exp', 255)->nullable()->change();
            $table->string('trial_sample_exp', 255)->nullable()->change();
        });
    }

    public function down()
    {
        Schema::table('table_productions', function (Blueprint $table) {
            // Kembalikan perubahan jika perlu
            if (Schema::hasColumn('table_productions', 'item_name')) {
                $table->renameColumn('item_name', 'item_id');
            }
            // Tidak perlu rollback kolom lain kecuali ingin benar-benar kembali ke awal
        });
    }
};
