<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarContenido extends Model
{
    use HasFactory;

    protected $fillable = ['navbar_seccion_id', 'nombre', 'ruta'];

    public function seccion()
    {
        return $this->belongsTo(NavbarSeccion::class, 'navbar_seccion_id');
    }
}

