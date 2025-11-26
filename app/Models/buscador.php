<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Buscador extends Model
{
    protected $table = 'vista_busqueda_general';
    public $timestamps = false;
    protected $fillable = ['nombre', 'descripcion', 'tipo'];

    // Scope para búsqueda
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', "%{$termino}%")
                     ->orWhere('descripcion', 'like', "%{$termino}%");
    }

    // Genera URL dinámica usando slug
    public function url()
    {
        $slug = Str::slug($this->nombre);

        switch($this->tipo){
            case 'contenido': return route('public.contenidos.show', ['slug' => $slug]);
            case 'seccion': return route('public.secciones.show', ['slug' => $slug]);
            case 'persona': return route('public.personas.show', ['slug' => $slug]);
            default: return '#';
        }
    }
}
