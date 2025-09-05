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
        Schema::table('model_items', function (Blueprint $table) {
            $table->string('product_picture')->nullable()->after('item_name');
        });
    }

    public function down()
    {
        Schema::table('model_items', function (Blueprint $table) {
            $table->dropColumn('product_picture');
        });
    }
};
