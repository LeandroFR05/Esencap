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
        //Quiero agregar unsigned a stockActual y quitarle nullable
        Schema::table('historial', function (Blueprint $table) {
            $table->unsignedSmallInteger('stockActual')->nullable(false)->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //Quiero quitar el unsigned de stockActual
        Schema::table('historial', function (Blueprint $table) {
            $table->smallInteger('stockActual')->nullable(true)->change();
        });
    }
};
