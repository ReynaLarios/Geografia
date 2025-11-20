<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('cuadros', function (Blueprint $table) {
            // Campos polimórficos
            $table->unsignedBigInteger('cuadrobable_id')->nullable()->after('archivo');
            $table->string('cuadrobable_type')->nullable()->after('cuadrobable_id');

            // Index para acelerar consultas
            $table->index(['cuadrobable_id', 'cuadrobable_type']);
        });
    }

    public function down(): void
    {
        Schema::table('cuadros', function (Blueprint $table) {
            $table->dropIndex(['cuadrobable_id', 'cuadrobable_type']);
            $table->dropColumn(['cuadrobable_id', 'cuadrobable_type']);
        });
    }
};
