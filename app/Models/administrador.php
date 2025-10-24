<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Administrador extends Model
{
    use HasFactory;

    protected $table = 'administradores';

    protected $fillable = [
        'nombre',
        'email',
        'contraseña',
        'activo',
    ];

    // Si quieres usar Hash automáticamente al crear un administrador
    // protected static function booted()
    // {
    //     static::creating(function ($admin) {
    //         $admin->contraseña = bcrypt($admin->contraseña);
    //     });
    // }
}
