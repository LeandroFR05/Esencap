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
            $table->increments('idFormula');
            $table->integer('idLote');
            $table->decimal('porcentaje', 10, 2);
            $table->smallInteger('idInsumo');
            $table->decimal('contenido', 10, 2);

            // Foreign keys
            $table->foreign('idLote')->references('idLote')->on('loteproductos')->cascadeOnDelete();
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
