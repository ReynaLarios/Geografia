<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class secciones extends Model
{
    use HasFactory;

     protected $table = 'secciones';

    public function contenido()
    {
        return $this->hasMany(contenidos::class);
       }
    
   
       }

    

