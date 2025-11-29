<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Contenidos extends Model
{
    use HasFactory;

    protected $table = 'contenidos';

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
        'seccion_id',
        'slug', 
    ];

    protected static function boot()
    {
        parent::boot();

        // Crear slug automáticamente
        static::creating(function ($contenido) {
            if (empty($contenido->slug)) {
                $contenido->slug = Str::slug($contenido->titulo) . '-' . uniqid();
            }
        });

        // Actualizar slug si cambia el título
        static::updating(function ($contenido) {
            if ($contenido->isDirty('titulo')) {
                $contenido->slug = Str::slug($contenido->titulo) . '-' . uniqid();
            }
        });
    }

    public function seccion()
    {
        return $this->belongsTo(Seccion::class);
    }

    public function archivos()
    {
        return $this->morphMany(Archivo::class, 'archivable');
    }

    public function cuadros()
    {
        return $this->morphMany(Cuadro::class, 'cuadrobable');
    }
}
