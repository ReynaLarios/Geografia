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
        'mostrar', // si lo sigues usando
        'cuadrobable_id',
        'cuadrobable_type',
    ];

    /**
     * Relación polimórfica hacia el modelo al que pertenece el cuadro
     * (puede ser Seccion u otro modelo en el futuro)
     */
    public function cuadrobable()
    {
        return $this->morphTo();
    }

    /**
     * Archivos asociados al cuadro (polimórficos)
     */
    public function archivos()
    {
        return $this->morphMany(\App\Models\Archivo::class, 'archivable');
    }
}
