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
    Schema::table('archivos', function (Blueprint $table) {
        $table->string('nombre')->nullable()->change(); // nombre puede ser null
        $table->string('ruta')->nullable(false)->change(); // ruta obligatoria
        $table->string('tipo')->nullable(false)->change(); // tipo obligatorio
    });
}

public function down(): void
{
    Schema::table('archivos', function (Blueprint $table) {
        $table->string('nombre')->nullable(false)->change();
        $table->string('ruta')->nullable()->change();
        $table->string('tipo')->nullable()->change();
    });
}
};