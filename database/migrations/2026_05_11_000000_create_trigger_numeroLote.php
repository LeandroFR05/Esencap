<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
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
    }
};
