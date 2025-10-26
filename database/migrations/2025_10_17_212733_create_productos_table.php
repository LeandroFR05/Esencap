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
        Schema::create('productos', function (Blueprint $table) {
            $table->smallIncrements('idProducto');
            $table->string('foto', 200)->nullable();
            $table->string('nombre', 50);
            $table->decimal('contenidoPorUnidad');
            $table->smallInteger('idBase')->unsigned();
            $table->smallInteger('idRecalculada')->unsigned();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('productos');
    }
};
