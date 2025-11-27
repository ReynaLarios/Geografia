<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;


class GenerarSlugs extends Command
{
    protected $signature = 'slugs:generar';
    protected $description = 'Genera slug para todas las tablas que lo requieren';

    public function handle()
    {
        // SECCIONES
        DB::table('secciones')->whereNull('slug')->orderBy('id')->chunk(100, function($rows){
            foreach ($rows as $row){
                DB::table('secciones')->where('id', $row->id)->update([
                    'slug' => Str::slug($row->nombre ?? 'seccion') . '-' . $row->id
                ]);
            }
        });

        // CONTENIDOS
        DB::table('contenidos')->whereNull('slug')->orderBy('id')->chunk(100, function($rows){
            foreach ($rows as $row){
                DB::table('contenidos')->where('id', $row->id)->update([
                    'slug' => Str::slug($row->titulo ?? 'contenido') . '-' . $row->id
                ]);
            }
        });

        // NAVBAR SECCIONES
        DB::table('navbar_secciones')->whereNull('slug')->orderBy('id')->chunk(100, function($rows){
            foreach ($rows as $row){
                DB::table('navbar_secciones')->where('id', $row->id)->update([
                    'slug' => Str::slug($row->nombre ?? 'navsec') . '-' . $row->id
                ]);
            }
        });

        // NAVBAR CONTENIDOS
        DB::table('navbar_contenidos')->whereNull('slug')->orderBy('id')->chunk(100, function($rows){
            foreach ($rows as $row){
                DB::table('navbar_contenidos')->where('id', $row->id)->update([
                    'slug' => Str::slug($row->titulo ?? 'navcont') . '-' . $row->id
                ]);
            }
        });

        // PERSONAS
        DB::table('personas')->whereNull('slug')->orderBy('id')->chunk(100, function($rows){
            foreach ($rows as $row){
                DB::table('personas')->where('id', $row->id)->update([
                    'slug' => Str::slug($row->nombre ?? 'persona') . '-' . $row->id
                ]);
            }
        });

        $this->info("Slugs generados correctamente ✔");

        return 0;
    }
}
