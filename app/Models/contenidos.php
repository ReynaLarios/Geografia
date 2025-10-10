<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contenidos extends Model 
{
    use HasFactory;
public function seccion()
{
    return $this->hasMany(Secciones::class, 'seccion_id');
}
}