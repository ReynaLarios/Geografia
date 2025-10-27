<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Casts\Attribute;


class secciones extends Model
{
    use HasFactory;

    protected $table = 'secciones';
    protected $fillable = ['nombre', 'descripcion'];


    
    public function contenidos()
{
    return $this->hasMany(contenidos::class, 'seccion_id');
}

 protected function firstName(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            
        );
    }
}

    

