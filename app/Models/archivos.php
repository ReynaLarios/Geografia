<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class archivos extends Model
{

     public function contenidos () {
return $this->hasMany(contenidos::class);
}

}
