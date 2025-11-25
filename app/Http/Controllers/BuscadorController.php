<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\VistaBusquedaGeneral;

class BuscadorController extends Controller
{
    public function buscar(Request $request)
{
    $search = $request->search;
    $resultados = [];

    if($search){
        $resultados = VistaBusquedaGeneral::where('nombre','LIKE',"%$search%")
            ->orWhere('descripcion','LIKE',"%$search%")
            ->get();
    }

    return response()->json($resultados);
}
}