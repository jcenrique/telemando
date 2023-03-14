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
        Schema::create('repostajes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vehiculo_id')->constrained()->on('vehiculos')->cascadeOnDelete();
            $table->date('fecha');
            $table->string('poblacion')->nullable();
            $table->string('establecimiento')->nullable();
            $table->integer('kilometraje');
            $table->string('combustible');
            $table->double('litros');
            $table->double('importe');
            $table->date('fecha_importacion');
            $table->unique(['vehiculo_id','fecha']);
           
          
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('repostajes');
    }
};
