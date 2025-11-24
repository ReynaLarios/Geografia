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

    public function contenidosNavbar()
    {
        return $this->hasMany(NavbarContenido::class, 'navbar_seccion_id', 'id');
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
