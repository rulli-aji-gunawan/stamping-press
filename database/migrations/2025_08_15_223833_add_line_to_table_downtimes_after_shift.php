<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('table_downtimes', function (Blueprint $table) {
            $table->string('line', 20)->nullable()->after('shift');
        });
    }

    public function down()
    {
        Schema::table('table_downtimes', function (Blueprint $table) {
            $table->dropColumn('line');
        });
    }
};
