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
        Schema::create('vehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('matricula', 20)->unique();
            $table->foreignId('tipovehiculo_id')->constrained()->on('tipovehiculos');
            $table->foreignId('marcavehiculo_id')->constrained()->on('marcavehiculos');
            $table->foreignId('modelovehiculo_id')->constrained()->on('modelovehiculos');
            $table->foreignId('departamento_id')->constrained()->on('departamentos');
            $table->foreignId('tecnologia_id')->constrained()->on('tecnologias');
            $table->foreignId('detalletecnologia_id')->nullable()->constrained()->on('detalletecnologias');
            $table->integer('kilometraje_inicial')->nullable();
            $table->date('fecha_matriculacion')->nullable();
            $table->string('observacion')->nullable();
            $table->enum('regimen',['PROPIEDAD', 'RENTING'])->nullable();
            $table->date('fecha_baja')->nullable()->default(null);

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
        Schema::dropIfExists('vehiculos');
    }
};
