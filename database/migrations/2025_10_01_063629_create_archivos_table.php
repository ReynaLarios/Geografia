<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('contenido_id');
            $table->string('nombre');
            $table->string('ruta');
            $table->string('tipo')->nullable();
            $table->timestamps();

           
            $table->foreign('contenido_id')->references('id')->on('contenidos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
