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
        Schema::create('production_problems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('input_production_id')->constrained('input_productions')->onDelete('cascade');
            $table->string('reporter', 50);
            $table->string('group', 10);
            $table->date('date');
            $table->string('shift', 10);
            $table->string('model', 20);
            $table->string('model_year', 10)->nullable();
            $table->string('item_name', 100);
            $table->string('coil_no', 20);
            $table->time('time_from');
            $table->time('time_until');
            $table->time('total_time')->nullable();
            $table->string('process_name', 50);
            $table->string('dt_category', 50);
            $table->string('dt_classification', 50);
            $table->text('problem_description');
            $table->text('root_cause');
            $table->text('counter_measure');
            $table->string('pic', 50);
            $table->string('status', 20);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_problems');
    }
};
