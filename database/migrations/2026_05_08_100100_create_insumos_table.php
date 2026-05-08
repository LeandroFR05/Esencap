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
        Schema::create('insumos', function (Blueprint $table) {
            $table->smallIncrements('idInsumo');
            $table->string('foto', 200)->nullable();
            $table->tinyInteger('idFamilia')->unsigned();
            $table->string('nombre', 50);
            $table->char('fase', 10);
            $table->string('unidadDeMedida', 30)->nullable();
            $table->boolean('estado')->default(true);
            $table->softDeletes();

            // Foreign key
            $table->foreign('idFamilia')->references('idFamilia')->on('familias')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insumos');
    }
};
