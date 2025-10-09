<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class secciones extends Model
{
    use HasFactory;

public function contenido()
{
    return $this->belongsTo(Contenidos::class, 'contenido_id');
}
}