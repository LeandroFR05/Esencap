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
        //Quiero actualizar la foreign key de idFamilia a restrictOnDelete, acualmente es cascadeOnDelete.
        Schema::table('insumos', function (Blueprint $table) {
            $table->dropForeign(['idFamilia']);
            $table->foreign('idFamilia')->references('idFamilia')->on('familias')->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('insumos', function (Blueprint $table) {
            $table->dropForeign(['idFamilia']);
            $table->foreign('idFamilia')->references('idFamilia')->on('familias')->cascadeOnDelete();
        });
    }
};
