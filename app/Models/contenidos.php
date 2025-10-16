<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contenidos extends Model
{
    use HasFactory;

    protected $table = 'contenidos';
    protected $fillable = ['titulo', 'descripcion', 'seccion_id'];

    public function secciones()
    {
        return $this->belongsTo(Secciones::class, 'seccion_id');
    }
}
