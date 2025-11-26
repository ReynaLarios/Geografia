<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buscador;

class BuscadorController extends Controller
{

    public function autocomplete(Request $request)
    {
        $q = $request->input('q');
        if (!$q) return response()->json([]);

        $resultados = Buscador::buscar($q)->take(10)->get();

        $resultados = $resultados->map(function($item){
            return [
                'nombre' => $item->nombre,
                'tipo' => $item->tipo,
                'descripcion' => $item->descripcion,
                'url' => $item->url(),
            ];
        });

        return response()->json($resultados);
    }

 
    public function resultados(Request $request)
    {
        $q = $request->input('q');
        $resultados = Buscador::buscar($q)->get();

        $resultados->transform(function($item){
            $item->url = $item->url();
            return $item;
        });

        return view('public.buscador.resultados', compact('resultados', 'q'));
    }
}
