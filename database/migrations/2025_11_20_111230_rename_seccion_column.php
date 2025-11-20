<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // Detectar si existe la columna antes de renombrarla
        $column = DB::select("
            SHOW COLUMNS FROM navbar_contenidos LIKE 'seccion_id'
        ");

        if (!empty($column)) {
            DB::statement("
                ALTER TABLE navbar_contenidos 
                CHANGE COLUMN seccion_id navbar_seccion_id BIGINT NULL
            ");
        }
    }

    public function down(): void
    {
        $column = DB::select("
            SHOW COLUMNS FROM navbar_contenidos LIKE 'navbar_seccion_id'
        ");

        if (!empty($column)) {
            DB::statement("
                ALTER TABLE navbar_contenidos 
                CHANGE COLUMN navbar_seccion_id seccion_id BIGINT NULL
            ");
        }
    }
};
