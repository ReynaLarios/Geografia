<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class contenidos extends Model
{
    use HasFactory;

protected $table = 'contenidos';

    public function seccion ()
    {
        return $this->belongsTo(secciones::class);


        public function archivos ()
        {
        return $this->belongsTo(archivos::class);
    }

     
   
}
}
