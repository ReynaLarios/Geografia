<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('contenidos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo'); 
            $table->text('descripcion'); 
            $table->unsignedBigInteger('archivo_id')->nullable(); 
            $table->foreign('archivo_id')->references('id')->on('archivos')->onDelete('set null');
            $table->unsignedBigInteger('administrador_id')->nullable(); 
            $table->foreign('administrador_id')->references('id')->on('administradores')->onDelete('set null');
            $table->timestamps(); 
        });
    }

    
    public function down(): void
    {
        Schema::dropIfExists('contenidos');
    }
};
