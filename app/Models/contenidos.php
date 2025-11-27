<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenidos extends Model
{
    use HasFactory;

    protected $table = 'contenidos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'seccion_id',
        'slug', 
    ];

    
    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
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
