<?php

// app/Models/VistaBusquedaGeneral.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class VistaBusquedaGeneral extends Model
{
    protected $table = 'vista_busqueda_general';
    public $timestamps = false; // la vista no tiene created_at/updated_at
}
