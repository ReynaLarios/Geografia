<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarContenido extends Model {
    use HasFactory;
    protected $fillable = ['titulo','ruta','navbar_seccion_id'];

    public function seccion() {
        return $this->belongsTo(NavbarSeccion::class, 'navbar_seccion_id');
    }
}
