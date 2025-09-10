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
        // 1. Ensure users table has is_admin column
        if (!Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->boolean('is_admin')->default(false)->after('email');
            });
        }

        // 2. Create table_productions table if not exists
        if (!Schema::hasTable('table_productions')) {
            Schema::create('table_productions', function (Blueprint $table) {
                $table->id();
                $table->string('reporter');
                $table->string('group');
                $table->date('date');
                $table->string('fy_n');
                $table->string('shift');
                $table->string('line');
                $table->string('start_time');
                $table->string('finish_time');
                $table->string('total_prod_time');
                $table->string('model');
                $table->string('model_year');
                $table->string('spm');
                $table->string('item_name');
                $table->string('coil_no');
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
                $table->string('rework_exp')->nullable();
                $table->string('scrap_exp')->nullable();
                $table->string('trial_sample_exp')->nullable();
                $table->timestamps();
            });
        }

        // 3. Create table_downtimes table if not exists
        if (!Schema::hasTable('table_downtimes')) {
            Schema::create('table_downtimes', function (Blueprint $table) {
                $table->id();
                $table->foreignId('table_production_id')->constrained()->onDelete('cascade');
                $table->string('reporter');
                $table->string('group');
                $table->date('date');
                $table->string('fy_n');
                $table->string('shift');
                $table->string('line');
                $table->string('model');
                $table->string('model_year');
                $table->string('item_name');
                $table->string('coil_no');
                $table->string('time_from');
                $table->string('time_until');
                $table->string('total_time');
                $table->string('process_name');
                $table->string('dt_category');
                $table->string('downtime_type');
                $table->string('dt_classification');
                $table->text('problem_description');
                $table->text('root_cause');
                $table->text('counter_measure');
                $table->string('pic');
                $table->string('status');
                $table->text('problem_picture')->nullable();
                $table->timestamps();
            });
        }

        // 4. Create table_defects table if not exists
        if (!Schema::hasTable('table_defects')) {
            Schema::create('table_defects', function (Blueprint $table) {
                $table->id();
                $table->foreignId('table_production_id')->constrained()->onDelete('cascade');
                $table->string('reporter');
                $table->string('group');
                $table->date('date');
                $table->string('fy_n');
                $table->string('shift');
                $table->string('line');
                $table->string('model');
                $table->string('model_year');
                $table->string('item_name');
                $table->string('coil_no');
                $table->string('defect_category');
                $table->string('defect_name');
                $table->integer('defect_qty_a');
                $table->integer('defect_qty_b');
                $table->string('defect_area');
                $table->timestamps();
            });
        }

        // 5. Create downtime_categories table if not exists
        if (!Schema::hasTable('downtime_categories')) {
            Schema::create('downtime_categories', function (Blueprint $table) {
                $table->id();
                $table->string('downtime_name');
                $table->string('downtime_type');
                $table->timestamps();
            });
        }

        // 6. Create downtime_classifications table if not exists
        if (!Schema::hasTable('downtime_classifications')) {
            Schema::create('downtime_classifications', function (Blueprint $table) {
                $table->id();
                $table->string('downtime_classification');
                $table->timestamps();
            });
        }

        // 7. Create model_items table if not exists
        if (!Schema::hasTable('model_items')) {
            Schema::create('model_items', function (Blueprint $table) {
                $table->id();
                $table->string('model_code');
                $table->string('model_year');
                $table->string('item_name');
                $table->text('product_picture')->nullable();
                $table->timestamps();
            });
        }

        // 8. Create process_names table if not exists
        if (!Schema::hasTable('process_names')) {
            Schema::create('process_names', function (Blueprint $table) {
                $table->id();
                $table->string('process_name');
                $table->timestamps();
            });
        }

        // 9. Ensure input_productions table has correct structure
        if (!Schema::hasTable('input_productions')) {
            Schema::create('input_productions', function (Blueprint $table) {
                $table->id();
                $table->string('reporter');
                $table->string('group');
                $table->date('date');
                $table->string('fy_n');
                $table->string('shift');
                $table->string('line');
                $table->string('start_time');
                $table->string('finish_time');
                $table->string('total_prod_time');
                $table->string('model');
                $table->string('model_year');
                $table->string('spm');
                $table->string('item_name');
                $table->string('coil_no');
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
                $table->string('rework_exp')->nullable();
                $table->string('scrap_exp')->nullable();
                $table->string('trial_sample_exp')->nullable();
                $table->timestamps();
            });
        }

        // 10. Ensure production_problems table has correct structure
        if (!Schema::hasTable('production_problems')) {
            Schema::create('production_problems', function (Blueprint $table) {
                $table->id();
                $table->foreignId('table_production_id')->constrained()->onDelete('cascade');
                $table->string('reporter');
                $table->string('group');
                $table->date('date');
                $table->string('fy_n');
                $table->string('shift');
                $table->string('line');
                $table->string('model');
                $table->string('model_year');
                $table->string('item_name');
                $table->string('coil_no');
                $table->string('time_from');
                $table->string('time_until');
                $table->string('total_time');
                $table->string('process_name');
                $table->string('dt_category');
                $table->string('downtime_type');
                $table->string('dt_classification');
                $table->text('problem_description');
                $table->text('root_cause');
                $table->text('counter_measure');
                $table->string('pic');
                $table->string('status');
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order (to handle foreign key constraints)
        Schema::dropIfExists('production_problems');
        Schema::dropIfExists('table_defects');
        Schema::dropIfExists('table_downtimes');
        Schema::dropIfExists('table_productions');
        Schema::dropIfExists('input_productions');
        Schema::dropIfExists('process_names');
        Schema::dropIfExists('model_items');
        Schema::dropIfExists('downtime_classifications');
        Schema::dropIfExists('downtime_categories');
        
        // Remove is_admin column from users table
        if (Schema::hasColumn('users', 'is_admin')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn('is_admin');
            });
        }
    }
};
