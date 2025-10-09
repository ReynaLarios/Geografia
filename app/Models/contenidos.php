<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contenidos extends Model 
{
    use HasFactory;
public function seccion()
{
    return $this->hasOne(Secciones::class, 'contenido_id');
}
}