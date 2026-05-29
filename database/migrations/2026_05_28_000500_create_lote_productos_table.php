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
        Schema::create('loteproductos', function (Blueprint $table) {
            $table->mediumIncrements('idLote');
            $table->unsignedSmallInteger('numeroLote');
            $table->unsignedSmallInteger('idProducto');
            $table->unsignedSmallInteger('stockInicial');
            $table->unsignedSmallInteger('stockActual');
            $table->date('fechaElaboracion');
            $table->boolean('estado')->default(true);
            $table->softDeletes();

            // Foreign key
            $table->foreign('idProducto')->references('idProducto')->on('productos')->cascadeOnDelete();
            
            // Unique constraint
            $table->unique(['idProducto', 'numeroLote']);
        });

        // Trigger para auto-incrementar numeroLote por producto
        DB::unprepared('
            CREATE TRIGGER tr_loteproductos_auto
            BEFORE INSERT ON loteproductos
            FOR EACH ROW
            BEGIN
              SET NEW.numeroLote = (
                SELECT COALESCE(MAX(numeroLote), 0) + 1
                FROM loteproductos
                WHERE idProducto = NEW.idProducto
              );
            END;
        ');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::unprepared('DROP TRIGGER IF EXISTS tr_loteproductos_auto');
        Schema::dropIfExists('loteproductos');
    }
};
