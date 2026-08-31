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
        Schema::create('lote_productos', function (Blueprint $table) {
            $table->increments('idLote');
            $table->smallInteger('numeroLote');
            $table->unsignedBigInteger('idUsuario');
            $table->unsignedInteger('idProducto');
            $table->smallInteger('stockInicial');
            $table->smallInteger('stockActual');
            $table->date('fechaElaboracion');
            $table->boolean('estado')->default(true);
            $table->softDeletes();

            // Foreign key
            $table->foreign('idUsuario')->references('id')->on('users');
            $table->foreign('idProducto')->references('idProducto')->on('productos')->cascadeOnDelete();

            // Unique constraint
            $table->unique(['idProducto', 'numeroLote']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('lote_productos');
    }
};
