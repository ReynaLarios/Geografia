<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('usuarios', function (Blueprint $table) {
            $table->id();
            $table->string('nombre', 100);
            $table->string('correo_electronico', 100);
            $table->string('usuario', 100);
            $table->string('contraseña', 100);
            $table->timestamps(); 
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('usuarios');
    }
};
