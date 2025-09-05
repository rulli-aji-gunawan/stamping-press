<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('table_productions', function (Blueprint $table) {
            $table->renameColumn('item_id', 'item_name');
        });
    }

    public function down()
    {
        Schema::table('table_productions', function (Blueprint $table) {
            $table->renameColumn('item_name', 'item_id');
        });
    }
};
