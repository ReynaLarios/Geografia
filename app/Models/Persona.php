<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'navbar_contenido_id',
        'nombre',
        'email',
        'telefono',
        'datos_adicionales',
        'foto',
    ];

    public function navbarContenido()
    {
        return $this->belongsTo(NavbarContenido::class);
    }
}
