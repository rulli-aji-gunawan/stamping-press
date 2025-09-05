<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
{
    Schema::table('table_productions', function (Blueprint $table) {
        $table->string('reporter')->nullable();
        $table->string('group')->nullable();
        $table->date('date')->nullable();
        $table->string('shift')->nullable();
        $table->time('start_time')->nullable();
        $table->time('finish_time')->nullable();
        $table->string('total_prod_time')->nullable();
        $table->string('model')->nullable();
        $table->string('model_year')->nullable();
        $table->decimal('spm', 5, 2)->nullable();
        $table->unsignedBigInteger('item_id')->nullable();
        $table->string('coil_no')->nullable();
        $table->integer('plan_a')->nullable();
        $table->integer('plan_b')->nullable();
        $table->integer('ok_a')->nullable();
        $table->integer('ok_b')->nullable();
        $table->integer('rework_a')->nullable();
        $table->integer('rework_b')->nullable();
        $table->integer('scrap_a')->nullable();
        $table->integer('scrap_b')->nullable();
        $table->integer('sample_a')->nullable();
        $table->integer('sample_b')->nullable();
        $table->string('rework_exp')->nullable();
        $table->string('scrap_exp')->nullable();
        $table->string('trial_sample_exp')->nullable();
    });
}

public function down()
{
    Schema::table('table_productions', function (Blueprint $table) {
        $table->dropColumn([
            'reporter', 'group', 'date', 'shift', 'start_time', 'finish_time', 'total_prod_time',
            'model', 'model_year', 'spm', 'item_id', 'coil_no', 'plan_a', 'plan_b', 'ok_a', 'ok_b',
            'rework_a', 'rework_b', 'scrap_a', 'scrap_b', 'sample_a', 'sample_b',
            'rework_exp', 'scrap_exp', 'trial_sample_exp'
        ]);
    });
}
};
