<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buscador extends Model
{
    protected $table = 'vista_busqueda_general';
    protected $primaryKey = 'id';
    public $incrementing = false;
    public $timestamps = false;
    protected $fillable = ['id','nombre','descripcion','tipo'];

   
    public function scopeBuscar($query, $termino)
    {
        return $query->where('nombre', 'like', "%{$termino}%")
                     ->orWhere('descripcion', 'like', "%{$termino}%");
    }

    public function url()
    {
        switch($this->tipo){
            case 'contenido': return route('public.contenidos.show', $this->id);
            case 'seccion': return route('public.secciones.show', $this->id);
            case 'navbar_contenido': return route('public.navbar.contenido.show', $this->id);
            case 'navbar_seccion': return route('public.navbar.secciones.show', $this->id);
            case 'persona': return route('public.personas.show', $this->id);
            default: return '#';
        }
    }
}
