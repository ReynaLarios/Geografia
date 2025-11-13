<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarSeccion extends Model
{
    use HasFactory;

  protected $fillable = ['nombre', 'descripcion', 'imagen', 'archivos'];


  public function contenidosNavbar() {
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
public function panel()
{
    $navbarSecciones = NavbarSeccion::all();
    return view('navbar.secciones.panel', compact('navbarSecciones'));
}


}



