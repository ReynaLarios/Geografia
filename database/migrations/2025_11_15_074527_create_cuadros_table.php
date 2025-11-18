<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cuadros', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('titulo')->nullable();
            $table->string('autor')->nullable();
            $table->string('nombre_real', 50)->nullable();
            $table->string('archivo')->nullable();
            $table->boolean('mostrar')->default(1);
            $table->timestamps();

            
            $table->unsignedBigInteger('cuadrobable_id')->nullable();
            $table->string('cuadrobable_type')->nullable();

            
            $table->index(['cuadrobable_id', 'cuadrobable_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cuadros');
    }
};
