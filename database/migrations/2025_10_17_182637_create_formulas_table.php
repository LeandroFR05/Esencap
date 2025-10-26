<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('formulaBase', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->smallInteger('idBase')->unsigned();
            $table->tinyInteger('idFamilia')->unsigned();
            $table->decimal('porcentaje');
        });

        Schema::create('formulaRecalculada', function (Blueprint $table) {
            $table->mediumIncrements('id');
            $table->smallInteger('idRecalculada')->unsigned();
            $table->smallInteger('idInsumo')->unsigned();
            $table->decimal('contenido');

            //Referencias
            $table->foreign('idInsumo')->references('idInsumo')->on('insumos')->restrictOnDelete(); 
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulaBase');
        Schema::dropIfExists('formulaRecalculada');
    }
};
