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
            $table->renameColumn('stock', 'stockInicial');
        });

        Schema::table('historial', function (Blueprint $table) {
            $table->smallInteger('stockActual')->nullable()->after('stockInicial');
        });

        DB::statement('UPDATE historial SET stockActual = stockInicial');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Eliminar columna nueva
        Schema::table('historial', function (Blueprint $table) {
            $table->dropColumn('stockActual');
        });

        // Volver al nombre original
        Schema::table('historial', function (Blueprint $table) {
            $table->renameColumn('stockInicial', 'stock');
        });
    }
};
