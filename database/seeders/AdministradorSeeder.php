<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Administrador;
use Illuminate\Support\Facades\Hash;

class AdministradorSeeder extends Seeder
{
    public function run(): void
    {
        Administrador::create([
            'nombre' => 'Admin Prueba',
            'email' => 'admin@prueba.com',
            'contraseña' => Hash::make('12345678'), // contraseña encriptada
        ]);
    }
}
