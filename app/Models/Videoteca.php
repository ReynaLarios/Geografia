<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videoteca extends Model
{
    use HasFactory;

    // Columnas que se pueden llenar masivamente
    protected $fillable = ['titulo', 'url', 'categoria_id'];

    // Relación con categoría
    public function categoria()
    {
        return $this->belongsTo(Categoria::class);
    }
}
