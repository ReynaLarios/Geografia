<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class NavbarSeccion extends Model
{
    use HasFactory;

    protected $table = 'navbar_secciones';

    protected $fillable = [
        'nombre',
        'descripcion',
        'imagen',
        'slug',  
    ];
        

   
    public function contenidosNavbar()
    {
        return $this->hasMany(NavbarContenido::class, 'navbar_seccion_id');
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
