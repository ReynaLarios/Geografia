<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenidos extends Model
{
    use HasFactory;

    protected $fillable = ['titulo','descripcion','seccion_id','imagen'];

    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'contenido_id');
    }

    public function cuadros()
    {
        return $this->hasMany(Cuadro::class, 'contenido_id');
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class, 'seccion_id');
    }
}





