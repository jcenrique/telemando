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
        Schema::create('equipo_ubicacion', function (Blueprint $table) {
            $table->foreignId('equipo_id')->constrained()->onDelete('cascade');
            $table->foreignId('ubicacion_id')->constrained()->on('ubicaciones')->onDelete('cascade');
            $table->unique(['equipo_id', 'ubicacion_id']);
        });
    }

    /**
     * Reverse the migrations.
     *rol
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('equipo_ubicacion');
    }
};
