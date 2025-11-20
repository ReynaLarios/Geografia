<?php

// 3. Navbar Secciones
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('navbar_secciones', function (Blueprint $table) {
            $table->boolean('oculto_publico')->default(false)->after('nombre');
        });
    }

    public function down(): void {
        Schema::table('navbar_secciones', function (Blueprint $table) {
            $table->dropColumn('oculto_publico');
        });
    }
};
