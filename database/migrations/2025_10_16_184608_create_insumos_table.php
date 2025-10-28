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
            $table->decimal('contenidoPorUnidad');
            $table->boolean('disponible')->default(true);
        });

        Schema::create('loteInsumos', function (Blueprint $table) {
            $table->mediumIncrements('idLote');
            $table->smallInteger('numeroLote')->unsigned();
            $table->smallInteger('idInsumo')->unsigned();
            $table->smallInteger('stock')->unsigned();
            $table->date('fechaVencimiento');
                
            //Clave foranea
            $table->foreign('idInsumo')->references('idInsumo')->on('insumos')->onDelete('cascade');
        });
    }

        
    

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('loteInsumos');
        Schema::dropIfExists('insumos');
       
    }
};
