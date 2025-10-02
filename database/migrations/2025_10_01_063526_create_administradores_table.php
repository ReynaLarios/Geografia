<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
   
    public function up(): void
    {
        Schema::create('administradores', function (Blueprint $table) {
            $table->id();
            $table->string('nombre'); 
            $table->string('email')->unique(); 
            $table->string('password'); 
            $table->boolean('activo')->default(true);
            $table->timestamp('email_verified_at')->nullable(); 
            $table->rememberToken(); 
            $table->timestamps(); 
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('administradores');
    }
};
