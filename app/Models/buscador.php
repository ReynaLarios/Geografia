<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Buscador extends Model
{
    protected $table = 'vista_busqueda_general';
    public $timestamps = false;

    protected $fillable = ['nombre', 'descripcion', 'tipo'];

  
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', "%{$termino}%")
                     ->orWhere('descripcion', 'like', "%{$termino}%");
    }

  
    public function url()
    {
        $slug = Str::slug($this->nombre);

        switch ($this->tipo) {
            case 'contenido':
                return route('public.contenidos.show', ['slug' => $slug]);

            case 'seccion':
                return route('public.secciones.show', ['slug' => $slug]);

            case 'navbar_contenido':
                return route('public.navbar.contenidos.show', ['slug' => $slug]);

            case 'navbar_seccion':
                return route('public.navbar.secciones.show', ['slug' => $slug]);

            case 'persona':
                return route('public.personas.show', ['slug' => $slug]);

            case 'inicios': 
            return route('public.inicio.show', ['slug' => $slug]);


            default:
                return '#';
        }
    }
}
