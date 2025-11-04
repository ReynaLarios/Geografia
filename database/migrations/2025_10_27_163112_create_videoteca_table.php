<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   public function up(): void
{
    Schema::create('videotecas', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->string('categoria');
        $table->string('url'); // URL de YouTube
        $table->string('miniatura'); // URL de miniatura
        $table->timestamps();
    });
}

    public function down(): void
    {
        Schema::dropIfExists('videoteca');
    }
};

