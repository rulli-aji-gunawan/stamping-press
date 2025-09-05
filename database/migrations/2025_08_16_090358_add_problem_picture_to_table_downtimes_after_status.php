<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
        public function up()
    {
        Schema::table('table_downtimes', function (Blueprint $table) {
            $table->string('problem_picture', 20)->nullable()->after('status');
        });
    }

    public function down()
    {
        Schema::table('table_downtimes', function (Blueprint $table) {
            $table->dropColumn('problem_picture');
        });
    }
};
