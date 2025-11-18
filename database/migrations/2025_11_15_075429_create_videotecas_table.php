<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videotecas', function (Blueprint $table) {
            $table->bigIncrements('id'); 
            $table->string('titulo', 255); 
            $table->string('url', 255); 
            $table->unsignedBigInteger('categoria_id')->nullable(); 
            $table->timestamps(); 

            
            $table->foreign('categoria_id')
                  ->references('id')
                  ->on('categorias')
                  ->onDelete('cascade')
                  ->onUpdate('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videotecas');
    }
};
