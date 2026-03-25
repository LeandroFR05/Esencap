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
        Schema::create('carritos', function (Blueprint $table) {
            $table->mediumIncrements('idCarrito');
            $table->unsignedMediumInteger('idVenta');
            $table->unsignedSmallInteger('idProducto');
            $table->unsignedSmallInteger('cantidad');

            $table->foreign('idVenta')
                ->references('idVenta')
                ->on('ventas')
                ->cascadeOnDelete();
            
            $table->foreign('idProducto')
                ->references('idProducto')
                ->on('productos')
                ->cascadeOnDelete();

            $table->unique(['idVenta', 'idProducto']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('carritos');
    }
};
