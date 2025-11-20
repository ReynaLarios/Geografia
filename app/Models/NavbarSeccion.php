<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\NavbarContenido;
use App\Models\Archivo;
use App\Models\Cuadro;

class NavbarSeccion extends Model
{
    use HasFactory;

    protected $table = 'navbar_secciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'archivos'
    ];

    // 👇 Evita errores al guardar/reconocer archivos en formato array
    protected $casts = [
        'archivos' => 'array',
    ];

    /**
     * Relación con los contenidos de navbar
     */
    public function contenidosNavbar()
    {
        // columna correcta 'navbar_seccion_id' en navbar_contenidos
        return $this->hasMany(NavbarContenido::class, 'navbar_seccion_id', 'id'); 
    }

    /**
     * Archivos relacionados (morph)
     */
    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }

    /**
     * Cuadros relacionados (morph)
     */
    public function cuadros()
    {
        return $this->morphMany(Cuadro::class, 'cuadrobable');
    }
}
