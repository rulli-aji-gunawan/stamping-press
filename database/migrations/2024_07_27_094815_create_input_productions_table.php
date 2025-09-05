<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('input_productions', function (Blueprint $table) {
            $table->id();
            $table->string('reporter', 50);
            $table->string('group', 10);
            $table->date('date');
            $table->string('shift', 10);
            $table->time('start_time');
            $table->time('finish_time');
            $table->string('total_prod_time', 10);
            $table->string('model', 20);
            $table->string('model_year', 10);
            $table->decimal('spm', 8, 2);
            $table->string('item_name', 100);
            $table->string('coil_no', 20);
            $table->integer('plan_a');
            $table->integer('plan_b');
            $table->integer('ok_a');
            $table->integer('ok_b');
            $table->integer('rework_a');
            $table->integer('rework_b');
            $table->integer('scrap_a');
            $table->integer('scrap_b');
            $table->integer('sample_a');
            $table->integer('sample_b');
            $table->string('rework_exp', 255)->nullable();
            $table->string('scrap_exp', 255)->nullable();
            $table->string('trial_sample_exp', 255)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('input_productions');
    }
};
