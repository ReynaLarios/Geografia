<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('archivos', function (Blueprint $table) {
       
            $table->foreign('contenido_id')->references('id')->on('contenidos')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('archivos', function (Blueprint $table) {
            $table->dropForeign(['contenido_id']); 
        });
    }
};
