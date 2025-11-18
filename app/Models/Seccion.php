<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Seccion extends Model
{
    use HasFactory;

    protected $table = 'secciones';

    protected $fillable = ['nombre', 'descripcion', 'imagen', 'archivos'];


   
    protected $casts = [
        'descripcion' => 'string',
    ];

    public function contenidos()
    {
        return $this->hasMany(Contenidos::class, 'seccion_id');
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



