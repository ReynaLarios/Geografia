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
    Schema::table('cuadros', function (Blueprint $table) {
        if (Schema::hasColumn('cuadros', 'mostrar')) {
            $table->dropColumn('mostrar');
        }
    });
}
};