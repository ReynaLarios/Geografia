<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cuadro extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'autor',
        'mostrar',
        'archivo',
        'cuadrobable_id',
        'cuadrobable_type',
    ];

   
    public function cuadrobable()
    {
        return $this->morphTo();
    }

    
    public function archivos()
    {
        return $this->morphMany(\App\Models\Archivo::class, 'archivable');
    }
}
