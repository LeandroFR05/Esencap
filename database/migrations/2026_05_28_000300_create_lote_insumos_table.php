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
        Schema::create('lote_insumos', function (Blueprint $table) {
            $table->increments('idLote');
            $table->smallInteger('numeroLote');
            $table->smallInteger('idInsumo');
            $table->decimal('stockInicial', 10, 2);
            $table->decimal('stockActual', 10, 2);
            $table->date('fechaVencimiento');
            $table->date('fechaCompra');
            $table->boolean('estado')->default(true);
            $table->softDeletes();

            // Foreign key
            $table->foreign('idInsumo')->references('idInsumo')->on('insumos')->cascadeOnDelete();

            // Unique constraint
            $table->unique(['idInsumo', 'numeroLote']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lote_insumos');
    }
};
