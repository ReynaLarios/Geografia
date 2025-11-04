<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuadro extends Model
{
    use HasFactory;

    protected $fillable = ['titulo', 'autor', 'archivo', 'mostrar', 'contenido_id'];

    public function contenido()
    {
        return $this->belongsTo(Contenidos::class, 'contenido_id');
    }
}


