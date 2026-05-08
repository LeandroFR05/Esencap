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
        Schema::create('formulas', function (Blueprint $table) {
            $table->mediumIncrements('idFormula');
            $table->mediumInteger('idHistorial')->unsigned();
            $table->tinyInteger('idFamilia')->unsigned();
            $table->decimal('porcentaje');
            $table->smallInteger('idInsumo')->unsigned();
            $table->decimal('contenido');

            // Foreign keys
            $table->foreign('idHistorial')->references('idHistorial')->on('historial')->cascadeOnDelete();
            $table->foreign('idInsumo')->references('idInsumo')->on('insumos')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('formulas');
    }
};
