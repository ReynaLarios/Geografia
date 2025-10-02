<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('secciones', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->text('descripcion')->nullable(); 
            $table->unsignedBigInteger('contenido_id')->nullable(); 
            $table->foreign('contenido_id')->references('id')->on('contenidos')->onDelete('set null');
            $table->timestamps(); 
        });
    }

   
    public function down(): void
    {
        Schema::dropIfExists('secciones');
    }
};
