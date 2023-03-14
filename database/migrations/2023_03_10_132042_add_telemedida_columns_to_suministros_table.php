<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('suministros', function (Blueprint $table) {
            $table->boolean('telegestion');
            $table->enum('comercializadora',['CLIENTES','CUR']);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('suministros', function (Blueprint $table) {
            $table->dropColumn('telegestion');
            $table->dropColumn('comercializadora');
            $table->dropSoftDeletes();
        });
    }
};
