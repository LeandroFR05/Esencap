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
        Schema::table('loteInsumos', function (Blueprint $table) {
        $table->dropColumn('fechaCompra');
        });

        Schema::table('loteInsumos', function (Blueprint $table) {
            $table->date('fechaCompra');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
