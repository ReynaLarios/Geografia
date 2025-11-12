<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
class Cuadro extends Model
{
    protected $fillable = [
        'cuadrobable_id',
        'cuadrobable_type',
        'titulo',
        'descripcion',
        'imagen'
    ];
    
public function cuadreable()
{
    return $this->morphTo();
}
}
