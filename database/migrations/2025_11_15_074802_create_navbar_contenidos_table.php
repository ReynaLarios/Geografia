<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navbar_contenidos', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->string('imagen')->nullable();
            $table->unsignedBigInteger('seccion_id')->nullable();
            $table->timestamps(); // created_at y updated_at

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navbar_contenidos');
    }
};
