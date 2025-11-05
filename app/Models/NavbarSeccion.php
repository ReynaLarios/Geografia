<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class NavbarSeccion extends Model
{
    use HasFactory;

    protected $table = 'navbar_seccions'; // Asegúrate de que tu tabla se llame así

    protected $fillable = [
        'nombre',
        'parent_id',
        'created_at',
        'updated_at'
    ];

    // 🔽 Relación con las secciones hijas
    public function hijos()
    {
        return $this->hasMany(NavbarSeccion::class, 'parent_id');
    }

    // 🔽 Relación con la sección padre (opcional)
    public function padre()
    {
        return $this->belongsTo(NavbarSeccion::class, 'parent_id');
    }
}
