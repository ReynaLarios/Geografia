<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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

    // 👇 ESTO ES LO QUE NECESITAS PARA EVITAR EL ERROR DE "Array to string conversion"
    protected $casts = [
        'archivos' => 'array',
    ];

    public function contenidosNavbar()
    {
        return $this->hasMany(NavbarContenido::class, 'seccion_id', 'id'); 
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }

    public function cuadros()
    {
        return $this->morphMany(Cuadro::class, 'cuadrobable');
    }

}


