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
        Schema::create('detalleVentas', function (Blueprint $table) {
            $table->increments('idDetalle');
            $table->integer('idVenta');
            $table->smallInteger('idProducto');
            $table->smallInteger('cantidad');
            $table->decimal('precioUnitario', 10, 2);

            // Foreign keys
            $table->foreign('idVenta')->references('idVenta')->on('ventas')->cascadeOnDelete();
            $table->foreign('idProducto')->references('idProducto')->on('productos')->cascadeOnDelete();

            // Unique constraint
            $table->unique(['idVenta', 'idProducto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('detalleVentas');
    }
};
