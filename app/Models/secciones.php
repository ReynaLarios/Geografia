<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class secciones extends Model
{
    use HasFactory;

public function contenidos()
{
    return $this->hasMany(Contenidos::class, 'seccion_id');
}

}
