<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Archivo extends Model
{
    use HasFactory;

    protected $fillable = ['nombre', 'ruta', 'tipo', 'contenido_id'];

    // Relación con Contenido
    public function contenido()
    {
        return $this->belongsTo(Contenidos::class);
    }
}
