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
            $table->unsignedInteger('idLote');
            $table->decimal('porcentaje', 10, 2);
            $table->unsignedInteger('idInsumo');
            $table->decimal('contenido', 10, 2);

            // Foreign keys
            $table->foreign('idLote')->references('idLote')->on('lote_productos')->cascadeOnDelete();
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
