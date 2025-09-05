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
        Schema::table('table_defects', function (Blueprint $table) {
            $table->unsignedBigInteger('input_production_id')->nullable()->after('id');
            $table->string('reporter')->nullable()->after('input_production_id');
            $table->string('group')->nullable()->after('reporter');
            $table->date('date')->nullable()->after('group');
            $table->string('shift')->nullable()->after('date');
            $table->string('model')->nullable()->after('shift');
            $table->string('model_year')->nullable()->after('model');
            $table->string('item_name')->nullable()->after('model_year');
            $table->string('coil_no')->nullable()->after('item_name');
            $table->string('defect_category')->nullable()->after('coil_no');
            $table->string('defect_name')->nullable()->after('defect_category');
            $table->integer('defect_qty_a')->nullable()->after('defect_name');
            $table->integer('defect_qty_b')->nullable()->after('defect_qty_a');
            $table->string('defect_area')->nullable()->after('defect_qty_b');
        });
    }

    public function down()
    {
        Schema::table('table_defects', function (Blueprint $table) {
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
                'defect_category',
                'defect_name',
                'defect_qty_a',
                'defect_qty_b',
                'defect_area'
            ]);
        });
    }
};
