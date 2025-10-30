<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenidos extends Model
{
    use HasFactory;

    protected $fillable = ['seccion_id', 'titulo', 'descripcion'];

    public function seccion()
    {
        return $this->belongsTo(Secciones::class, 'seccion_id');
    }

    public function archivos()
    {
        return $this->hasMany(Archivo::class, 'contenido_id'); 
    }
}
