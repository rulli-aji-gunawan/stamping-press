<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('input_productions', function (Blueprint $table) {
            $table->string('fy_n', 20)->nullable()->after('date');
        });
    }

    public function down()
    {
        Schema::table('input_productions', function (Blueprint $table) {
            $table->dropColumn('fy_n');
        });
    }
};