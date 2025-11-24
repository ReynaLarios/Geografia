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
    ];

    /**
     * Relación con NavbarContenido
     * Una sección tiene muchos contenidos.
     */
    public function contenidosNavbar()
    {
        return $this->hasMany(NavbarContenido::class, 'navbar_seccion_id', 'id');
    }

    /**
     * Archivos adicionales de la sección (Polymorphic)
     * Se guarda en `archivos.archivable_id` y `archivos.archivable_type`
     */
    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }

    /**
     * Cuadros relacionados (Polymorphic)
     * Se guarda en `cuadros.cuadrobable_id` y `cuadros.cuadrobable_type`
     */
    public function cuadros()
    {
        return $this->morphMany(Cuadro::class, 'cuadrobable');
    }
}
