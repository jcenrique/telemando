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
        Schema::create('suministros', function (Blueprint $table) {
            $table->id();
            $table->integer('position');
            $table->foreignId('zona_id')->constrained()->on('zonas');
            $table->string('poblacion', 50);
            $table->string('direccion');
            $table->string('instalacion',150)->nullable();
            $table->foreignId('tipo_id')->nullable()->constrained()->on('tipos');
            $table->string('CUP',50);
            $table->integer('contrato')->default(0);
            $table->string('num_contador')->nullable();
            $table->foreignId('tarifa_id')->constrained()->on('tarifas');
            $table->string('P1',15)->nullable();
            $table->string('P2',15)->nullable();
            $table->string('P3',15)->nullable();
            $table->string('P4',15)->nullable();
            $table->string('P5',15)->nullable();
            $table->string('P6',15)->nullable();
            $table->foreignId('tension_id')->constrained()->on('tensiones');
            $table->enum('medida',['DIRECTA', 'INDIRECTA'])->nullable();
            $table->foreignId('relacion_id')->nullable()->constrained()->on('relaciones');
            $table->enum('icp',['DISTRIBUIDORA','SI','NO'])->nullable();
            $table->enum('contador',['DISTRIBUIDORA','SI','CLIENTE','i-DE'])->nullable();
            $table->string('observacion')->nullable();


            

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
        Schema::dropIfExists('suministros');
    }
};
