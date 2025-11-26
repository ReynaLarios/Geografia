<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buscador extends Model
{
    protected $table = 'vista_busqueda_general';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion', 'url', 'tipo'];

    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', "%{$termino}%")
                     ->orWhere('descripcion', 'like', "%{$termino}%");
    }

    public function url()
    {
        return $this->url;  
    }
}
