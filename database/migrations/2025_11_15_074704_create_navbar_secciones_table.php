<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('navbar_secciones', function (Blueprint $table) {
            $table->bigIncrements('id');

            
            $table->unsignedBigInteger('parent_id')->nullable();

            $table->string('nombre', 50);
            $table->string('descripcion', 100)->nullable();
            $table->string('imagen', 255)->nullable();
            $table->string('ruta', 255)->nullable();

            
            $table->timestamps();

           
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('navbar_secciones');
    }
};
