<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Buscador extends Model
{
    protected $table = 'buscador_general';
    public $timestamps = false;

    public function getUrlAttribute()
    {
        return url("/{$this->tipo}/{$this->id}");
    }
}