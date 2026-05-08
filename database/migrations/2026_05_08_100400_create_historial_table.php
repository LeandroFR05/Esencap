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
        Schema::create('historial', function (Blueprint $table) {
            $table->mediumIncrements('idHistorial');
            $table->smallInteger('idProducto')->unsigned();
            $table->smallInteger('stockInicial')->unsigned();
            $table->smallInteger('stockActual')->nullable();
            $table->date('fechaElaboracion');

            // Foreign key
            $table->foreign('idProducto')->references('idProducto')->on('productos')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('historial');
    }
};
