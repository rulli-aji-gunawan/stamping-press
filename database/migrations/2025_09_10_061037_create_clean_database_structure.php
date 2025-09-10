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
        // 1. Users table (based on User model)
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop tables in reverse order to handle foreign key constraints
        Schema::dropIfExists('table_defects');
        Schema::dropIfExists('table_downtimes');
        Schema::dropIfExists('production_problems');
        Schema::dropIfExists('table_productions');
        Schema::dropIfExists('input_productions');
        Schema::dropIfExists('model_items');
        Schema::dropIfExists('process_names');
        Schema::dropIfExists('downtime_classifications');
        Schema::dropIfExists('downtime_categories');
        Schema::dropIfExists('personal_access_tokens');
        Schema::dropIfExists('failed_jobs');
        Schema::dropIfExists('job_batches');
        Schema::dropIfExists('jobs');
        Schema::dropIfExists('cache_locks');
        Schema::dropIfExists('cache');
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }que();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->boolean('is_admin')->default(false);
            $table->rememberToken();
            $table->timestamps();
        });

        // 2. Password reset tokens table
        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        // 3. Sessions table
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index();
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });

        // 4. Cache table
        Schema::create('cache', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->mediumText('value');
            $table->integer('expiration');
        });

        // 5. Cache locks table
        Schema::create('cache_locks', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->string('owner');
            $table->integer('expiration');
        });

        // 6. Jobs table
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->string('queue')->index();
            $table->longText('payload');
            $table->unsignedTinyInteger('attempts');
            $table->unsignedInteger('reserved_at')->nullable();
            $table->unsignedInteger('available_at');
            $table->unsignedInteger('created_at');
        });

        // 7. Job batches table
        Schema::create('job_batches', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->string('name');
            $table->integer('total_jobs');
            $table->integer('pending_jobs');
            $table->integer('failed_jobs');
            $table->longText('failed_job_ids');
            $table->mediumText('options')->nullable();
            $table->integer('cancelled_at')->nullable();
            $table->integer('created_at');
            $table->integer('finished_at')->nullable();
        });

        // 8. Failed jobs table
        Schema::create('failed_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->unique();
            $table->text('connection');
            $table->text('queue');
            $table->longText('payload');
            $table->longText('exception');
            $table->timestamp('failed_at')->useCurrent();
        });

        // 9. Personal access tokens table
        Schema::create('personal_access_tokens', function (Blueprint $table) {
            $table->id();
            $table->morphs('tokenable');
            $table->string('name');
            $table->string('token', 64)->unique();
            $table->text('abilities')->nullable();
            $table->timestamp('last_used_at')->nullable();
            $table->timestamp('expires_at')->nullable();
            $table->timestamps();
        });

        // 10. Downtime Categories table (based on DowntimeCategory model)
        Schema::create('downtime_categories', function (Blueprint $table) {
            $table->id();
            $table->string('downtime_name');
            $table->string('downtime_type');
            $table->timestamps();
        });

        // 11. Downtime Classifications table (based on DowntimeClassification model)
        Schema::create('downtime_classifications', function (Blueprint $table) {
            $table->id();
            $table->string('downtime_classification');
            $table->timestamps();
        });

        // 12. Process Names table (based on ProcessName model)
        Schema::create('process_names', function (Blueprint $table) {
            $table->id();
            $table->string('process_name');
            $table->timestamps();
        });

        // 13. Model Items table (based on ModelItem model)
        Schema::create('model_items', function (Blueprint $table) {
            $table->id();
            $table->string('model_code');
            $table->string('model_year');
            $table->string('item_name');
            $table->text('product_picture')->nullable();
            $table->timestamps();
        });

        // 14. Input Productions table (based on InputProduction model)
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

        // 15. Table Productions table (based on TableProduction model)
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

        // 16. Production Problems table (based on ProductionProblem model)
        Schema::create('production_problems', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_production_id')->constrained('table_productions')->onDelete('cascade');
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

        // 17. Table Downtimes table (based on TableDowntime model)
        Schema::create('table_downtimes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_production_id')->constrained('table_productions')->onDelete('cascade');
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

        // 18. Table Defects table (based on TableDefect model)
        Schema::create('table_defects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('table_production_id')->constrained('table_productions')->onDelete('cascade');
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
    }ate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('clean_database_structure', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clean_database_structure');
    }
};
