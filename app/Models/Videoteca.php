<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Videoteca extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'url',
        'categoria',
        'anio',
        'descripcion',
    ];
}


