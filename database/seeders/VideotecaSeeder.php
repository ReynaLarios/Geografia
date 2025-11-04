<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Videoteca;

class VideotecaSeeder extends Seeder
{
    public function run()
    {
        Videoteca::create([
            'titulo' => 'Video de prueba',
            'descripcion' => 'Descripción del video',
            'url' => 'https://www.youtube.com/watch?v=dQw4w9WgXcQ',
            'categoria_id' => 1
        ]);
    }
}
