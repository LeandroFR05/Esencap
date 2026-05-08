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
        Schema::create('loteInsumos', function (Blueprint $table) {
            $table->mediumIncrements('idLote');
            $table->smallInteger('numeroLote')->unsigned();
            $table->smallInteger('idInsumo')->unsigned();
            $table->decimal('stockInicial', 10, 2);
            $table->decimal('stockActual', 10, 2);
            $table->date('fechaVencimiento');
            $table->date('fechaCompra');

            // Foreign key
            $table->foreign('idInsumo')->references('idInsumo')->on('insumos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loteInsumos');
    }
};
