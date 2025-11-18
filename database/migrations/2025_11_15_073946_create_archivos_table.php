<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('archivos', function (Blueprint $table) {
            $table->id(); 
            $table->string('nombre'); 
            $table->string('ruta');   
            $table->string('tipo');   
            $table->timestamps();     
            $table->unsignedBigInteger('archivable_id')->nullable();
            $table->string('archivable_type')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('archivos');
    }
};
