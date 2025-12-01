<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'nombre',
        'email',
        'datos_personales',
        'foto',
        'slug', 
    ];

    
    public function navbarContenido()
    {
        return $this->belongsTo(NavbarContenido::class);
    }

   
    protected static function booted()
    {
        
        static::creating(function ($persona) {
            if (!$persona->slug) {
                $persona->slug = Str::slug($persona->nombre);
            }
        });

       
        static::updating(function ($persona) {
            if ($persona->isDirty('nombre')) {
                $persona->slug = Str::slug($persona->nombre);
            }
        });
    }
}
