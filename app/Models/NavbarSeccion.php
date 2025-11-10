<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarSeccion extends Model
{
    protected $fillable = ['nombre', 'ruta'];

   public function contenidosNavbar()
{
    return $this->hasMany(NavbarContenido::class, 'navbar_seccion_id');
}

}


