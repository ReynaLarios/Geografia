<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarContenido extends Model
{
    protected $fillable = [
        'navbar_seccion_id',
        'titulo',
        'descripcion',
        'imagen'
    ];

    public function seccion()
    {
        return $this->belongsTo(NavbarSeccion::class, 'navbar_seccion_id');
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
