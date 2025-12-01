<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('navbar_secciones', function (Blueprint $table) {
            // Eliminar la columna 'ruta' si existe
            if (Schema::hasColumn('navbar_secciones', 'ruta')) {
                $table->dropColumn('ruta');
            }
        });
    }

    public function down(): void
    {
        Schema::table('navbar_secciones', function (Blueprint $table) {
            // Volver a crear la columna en caso de rollback
            $table->string('ruta')->nullable();
        });
    }
};
