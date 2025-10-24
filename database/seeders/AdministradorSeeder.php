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
            'email' => 'reyna@gmail.com',
            'password' => Hash::make('reyna123'), 
        ]);
    }
}
