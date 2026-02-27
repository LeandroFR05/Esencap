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
        // Tabla loteInsumos: eliminar columna stock y agregar nuevas
        Schema::table('loteInsumos', function (Blueprint $table) {
            $table->date('fechaCompra')->default(DB::raw('CURRENT_DATE'));
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Revertir cambios en insumos
        Schema::table('insumos', function (Blueprint $table) {
            $table->decimal('contenidoPorUnidad');
        });

        // Revertir cambios en loteInsumos
        Schema::table('loteInsumos', function (Blueprint $table) {
            $table->dropColumn(['stockInicial', 'stockActual', 'fechaCompra']);
            $table->decimal('stock');
        });
    }
};
