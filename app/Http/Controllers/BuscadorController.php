<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;
use App\Models\Seccion;
use App\Models\Contenidos;
use App\Models\Persona;
use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;

class BuscadorController extends Controller
{
    protected $modelConfig = [
        'secciones' => [
            'model'  => Seccion::class,
            'titulo' => 'nombre',
            'campos' => ['nombre', 'descripcion', 'slug'],
            'oculto' => true,
        ],
        'contenidos' => [
            'model'  => Contenidos::class,
            'titulo' => 'titulo',
            'campos' => ['titulo', 'descripcion', 'slug', 'imagen', 'archivos'],
            'oculto' => false,
        ],
        'personas' => [
            'model'  => Persona::class,
            'titulo' => 'nombre',
            'campos' => ['nombre', 'slug', 'foto', 'email', 'datos_personales'],
            'oculto' => false,
        ],
        'navbar_secciones' => [
            'model'  => NavbarSeccion::class,
            'titulo' => 'nombre',
            'campos' => ['nombre', 'descripcion', 'slug', 'imagen', 'archivos'],
            'oculto' => true,
        ],
        'navbar_contenidos' => [
            'model'  => NavbarContenido::class,
            'titulo' => 'titulo',
            'campos' => ['titulo', 'descripcion', 'slug', 'imagen', 'archivos'],
            'oculto' => true,
        ],
    ];

   
    public function autocomplete(Request $request)
    {
        $q = trim($request->input('q'));
        if (!$q) return response()->json([]);

        $resultados = collect();

        foreach ($this->modelConfig as $tipo => $config) {
            $resultados = $resultados->merge($this->buscarTabla($q, $tipo, $config));
        }

      
        $resultados = $resultados->filter(fn($item) => !empty($item->slug));

        return response()->json($resultados);
    }

  
    public function resultados(Request $request)
    {
        $q = trim($request->input('q'));
        $resultados = collect();

        foreach ($this->modelConfig as $tipo => $config) {
            $resultados = $resultados->merge($this->buscarTabla($q, $tipo, $config));
        }

        $resultados = $resultados->filter(fn($item) => !empty($item->slug));

        return view('public.buscador.resultados', compact('resultados', 'q'));
    }

   
    protected function buscarTabla($q, $tipo, $config)
    {
        $model = $config['model'];
        $titulo = $config['titulo'];
        $campos = $config['campos'];

        $query = $model::query();

      
        if ($config['oculto'] && Schema::hasColumn((new $model)->getTable(), 'oculto_publico')) {
            $query->where('oculto_publico', false);
        }

        $query->where(function($qQuery) use ($q, $titulo, $campos, $model) {
            $qQuery->where($titulo, 'like', "%{$q}%");

            if (in_array('descripcion', $campos) && Schema::hasColumn((new $model)->getTable(), 'descripcion')) {
                $qQuery->orWhere('descripcion', 'like', "%{$q}%");
            }
        });

        
        $camposExistentes = array_filter($campos, fn($c) => Schema::hasColumn((new $model)->getTable(), $c));
        $result = $query->get($camposExistentes);

      
        $result->each(function($item) use ($tipo) {
            $item->tipo = $tipo;

            if ($tipo === 'contenidos' || $tipo === 'navbar_contenidos') {
                $item->nombre = $item->titulo ?? 'Sin título';
            } elseif ($tipo === 'personas') {
                $item->nombre = $item->nombre ?? 'Sin nombre';
            } else {
                $item->nombre = $item->nombre ?? 'Sin nombre';
            }

            switch ($tipo) {
                case 'secciones':
                    $item->url = route('public.secciones.show', $item->slug);
                    break;
                case 'contenidos':
                    $item->url = route('public.contenidos.show', $item->slug);
                    break;
                case 'personas':
                    $item->url = route('public.personas.show', $item->slug);
                    break;
                case 'navbar_secciones':
                    $item->url = route('public.navbar.secciones.show', $item->slug);
                    break;
                case 'navbar_contenidos':
                    $item->url = route('public.navbar.contenido.show', $item->slug);
                    break;
                default:
                    $item->url = '#';
            }
        });

        return $result;
    }
}
