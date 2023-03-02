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
        Schema::create('modelovehiculos', function (Blueprint $table) {
            $table->id();
            $table->string('modelo', 100);
            $table->unique(['modelo','marcavehiculo_id']);
            $table->foreignId('marcavehiculo_id')->constrained()->on('marcavehiculos')->cascadeOnDelete();
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
        Schema::dropIfExists('modelovehiculos');
    }
};
