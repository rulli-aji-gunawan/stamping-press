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
        Schema::table('table_downtimes', function (Blueprint $table) {
            $table->unsignedBigInteger('input_production_id')->nullable();
            $table->string('reporter')->nullable();
            $table->string('group')->nullable();
            $table->date('date')->nullable();
            $table->string('shift')->nullable();
            $table->string('model')->nullable();
            $table->string('model_year')->nullable();
            $table->string('item_name')->nullable();
            $table->string('coil_no')->nullable();
            $table->time('time_from')->nullable();
            $table->time('time_until')->nullable();
            $table->string('total_time')->nullable();
            $table->string('process_name')->nullable();
            $table->string('dt_category')->nullable();
            $table->string('downtime_type')->nullable();
            $table->string('dt_classification')->nullable();
            $table->text('problem_description')->nullable();
            $table->text('root_cause')->nullable();
            $table->text('counter_measure')->nullable();
            $table->string('pic')->nullable();
            $table->string('status')->nullable();
        });
    }

    public function down()
    {
        Schema::table('table_downtimes', function (Blueprint $table) {
            $table->dropColumn([
                'input_production_id',
                'reporter',
                'group',
                'date',
                'shift',
                'model',
                'model_year',
                'item_name',
                'coil_no',
                'time_from',
                'time_until',
                'total_time',
                'process_name',
                'dt_category',
                'downtime_type',
                'dt_classification',
                'problem_description',
                'root_cause',
                'counter_measure',
                'pic',
                'status'
            ]);
        });
    }
};
