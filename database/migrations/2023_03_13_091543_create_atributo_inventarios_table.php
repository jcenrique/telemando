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
        Schema::create('inventario_atributos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('inventario_id')->constrained()->on('inventarios')->cascadeOnDelete();
            $table->string('name',30);
            $table->enum('tipo_campo', ['TEXTO LIBRE', 'NUMERICO' , 'SI/NO' , 'LISTA' , 'FECHA']);
            $table->json('value');
            $table->boolean('obligatorio');
            $table->json('default_value');
            
            $table->softDeletes();
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
        Schema::dropIfExists('inventario_atributos');
    }
};
