<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('navbar_contenidos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('ruta')->nullable();
            $table->foreignId('navbar_seccion_id')->constrained('navbar_secciones')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void {
        Schema::dropIfExists('navbar_contenidos');
    }
};
