<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('navbar_contenido_id')->constrained('navbar_contenidos')->onDelete('cascade'); // relación con navbar_contenidos
            $table->string('nombre');
            $table->string('email')->unique();
            $table->text('datos_adicionales')->nullable();
            $table->string('foto')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('personas');
    }
};
