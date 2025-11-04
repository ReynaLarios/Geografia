<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
   public function up()
{
    Schema::create('cuadros', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('contenido_id')->nullable();
        $table->string('titulo')->nullable();
        $table->string('autor')->nullable();
        $table->string('archivo')->nullable(); // ruta del documento
        $table->boolean('visible')->default(true);
        $table->timestamps();

        $table->foreign('contenido_id')->references('id')->on('contenidos')->onDelete('cascade');
    });
}

};
