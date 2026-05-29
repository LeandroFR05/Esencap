<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

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
            $table->boolean('estado')->default(true);
            $table->softDeletes();

            // Foreign key
            $table->foreign('idInsumo')->references('idInsumo')->on('insumos')->cascadeOnDelete();
            
            // Unique constraint
            $table->unique(['idInsumo', 'numeroLote']);
        });

        // Trigger para auto-incrementar numeroLote por insumo
        DB::unprepared('
            CREATE TRIGGER tr_numeroLote_auto
            BEFORE INSERT ON loteInsumos
            FOR EACH ROW
            BEGIN
              SET NEW.numeroLote = (
                SELECT COALESCE(MAX(numeroLote), 0) + 1
                FROM loteInsumos
                WHERE idInsumo = NEW.idInsumo
              );
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tr_numeroLote_auto');
        Schema::dropIfExists('loteInsumos');
    }
};
