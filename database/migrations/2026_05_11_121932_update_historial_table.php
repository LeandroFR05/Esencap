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
        Schema::table('historial', function (Blueprint $table) {
            $table->unsignedSmallInteger('numeroLote')->after('idHistorial');
            $table->unique(['idProducto', 'numeroLote']);
        });

        DB::unprepared('
            CREATE TRIGGER tr_historial_auto
            BEFORE INSERT ON historial
            FOR EACH ROW
            BEGIN
              SET NEW.numeroLote = (
                SELECT COALESCE(MAX(numeroLote), 0) + 1
                FROM historial
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
        DB::unprepared('DROP TRIGGER IF EXISTS tr_historial_auto');
        
        Schema::table('historial', function (Blueprint $table) {
            $table->dropColumn('numeroLote');
        });
    }
};
