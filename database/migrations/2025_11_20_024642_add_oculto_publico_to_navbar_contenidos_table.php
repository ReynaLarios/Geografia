<?php

// 4. Navbar Contenidos
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::table('navbar_contenidos', function (Blueprint $table) {
            $table->boolean('oculto_publico')->default(false)->after('titulo');
        });
    }

    public function down(): void {
        Schema::table('navbar_contenidos', function (Blueprint $table) {
            $table->dropColumn('oculto_publico');
        });
    }
};
