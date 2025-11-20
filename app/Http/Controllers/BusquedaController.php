<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Contenidos;
use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;
use App\Models\Videoteca;
use App\Models\Inicio;

class BusquedaController extends Controller
{
    // Buscador público
    public function buscarPublico(Request $request)
    {
        return $this->buscarGeneral($request);
    }

    // Buscador administrador
    public function buscarAdmin(Request $request)
    {
        return $this->buscarGeneral($request);
    }

    // Función común
    private function buscarGeneral(Request $request)
    {
        if ($request->ajax()) {
            $query = $request->input('query');
            $resultados = collect();

            $resultados = $resultados->merge(
                Seccion::where('nombre', 'like', "%{$query}%")
                       ->orWhere('titulo', 'like', "%{$query}%")
                       ->get()
            );

            $resultados = $resultados->merge(
                Contenidos::where('nombre', 'like', "%{$query}%")
                          ->orWhere('titulo', 'like', "%{$query}%")
                          ->get()
            );

            $resultados = $resultados->merge(
                NavbarSeccion::where('nombre', 'like', "%{$query}%")
                             ->orWhere('titulo', 'like', "%{$query}%")
                             ->get()
            );

            $resultados = $resultados->merge(
                NavbarContenido::where('nombre', 'like', "%{$query}%")
                               ->orWhere('titulo', 'like', "%{$query}%")
                               ->get()
            );

            $resultados = $resultados->merge(
                Videoteca::where('nombre', 'like', "%{$query}%")
                         ->orWhere('titulo', 'like', "%{$query}%")
                         ->get()
            );

            $resultados = $resultados->merge(
                Inicio::where('nombre', 'like', "%{$query}%")
                      ->orWhere('titulo', 'like', "%{$query}%")
                      ->get()
            );

            // HTML de resultados
            $output = '';
            if ($resultados->count() > 0) {
                foreach ($resultados as $item) {
                    $nombre = $item->nombre ?? '';
                    $titulo = $item->titulo ?? '';
                    $output .= '<li><strong>'.$nombre.'</strong>';
                    if ($titulo) $output .= ' - '.$titulo;
                    $output .= '</li>';
                }
            } else {
                $output = '<li>No se encontraron resultados</li>';
            }

            return response()->json(['html' => $output]);
        }
    }
}
