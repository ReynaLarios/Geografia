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
    Schema::table('secciones', function ($table) {
        $table->text('descripcion')->change();
    });
}

public function down()
{
    Schema::table('secciones', function ($table) {
        $table->string('descripcion', 255)->change();
    });
}
};