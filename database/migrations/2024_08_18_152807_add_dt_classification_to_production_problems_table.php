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
        // Check if column doesn't exist before adding
        if (!Schema::hasColumn('production_problems', 'dt_classification')) {
            Schema::table('production_problems', function (Blueprint $table) {
                $table->string('dt_classification')->after('dt_category');
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_problems', function (Blueprint $table) {
            $table->dropColumn('dt_classification');
        });
    }
};
