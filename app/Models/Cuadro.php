<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Cuadro extends Model


{
    protected $fillable = ['contenido_id', 'titulo', 'autor','nombre_real','archivo', 'mostrar'];

    public function contenido()
    {
        return $this->belongsTo(Contenidos::class);
    }
}
