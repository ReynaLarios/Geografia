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
    Schema::table('secciones', function (Blueprint $table) {
        $table->longText('descripcion')->change();
    });
}

public function down()
{
    Schema::table('secciones', function (Blueprint $table) {
        $table->text('descripcion')->change(); // o varchar si estaba así
    });
}
};