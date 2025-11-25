<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Buscador;

class BuscadorPublicoController extends Controller
{
  
    public function autocomplete(Request $request)
    {
        $q = $request->input('q');

        if (!$q) return response()->json([]);

        $resultados = Buscador::buscar($q)->take(10)->get();

        return response()->json($resultados->map(function($item){
            return [
                'nombre' => $item->nombre,
                'tipo' => $item->tipo,
                'url' => $item->url(),
            ];
        }));
    }

   
    public function resultados(Request $request)
    {
        $q = $request->input('q');

        $resultados = Buscador::buscar($q)->get();

        return view('buscador.resultados', compact('resultados','q'));
    }
}
