<?php

namespace App\Http\Controllers;

use App\Models\NavbarSeccion;
use App\Models\Cuadro;
use Illuminate\Http\Request;

class NavbarSeccionesController extends Controller
{
    public function index()
    {
        $secciones = NavbarSeccion::all();
        return view('navbar.secciones.index', compact('secciones'));
    }

    public function crear()
    {
        return view('navbar.secciones.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required'
        ]);

        // Imagen principal
        $imagen = null;
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        // Archivos múltiples
        $archivosGuardados = [];
        if ($request->hasFile('archivos')) {
            foreach($request->file('archivos') as $file){
                $archivosGuardados[] = $file->store('archivos', 'public');
            }
        }

        // Crear sección
        $seccion = NavbarSeccion::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen' => $imagen,
            'archivos' => $archivosGuardados
        ]);

        // Guardar cuadros polimórficos
        if ($request->cuadros) {
            foreach ($request->cuadros as $cuadro) {

                $archivoCuadro = null;
                if (isset($cuadro['archivo'])) {
                    $archivoCuadro = $cuadro['archivo']->store('cuadros', 'public');
                }

                Cuadro::create([
                    'cuadrobable_id' => $seccion->id,
                    'cuadrobable_type' => NavbarSeccion::class,
                    'titulo' => $cuadro['titulo'] ?? '',
                    'autor' => $cuadro['autor'] ?? '',
                    'archivo' => $archivoCuadro,
                    'mostrar' => isset($cuadro['mostrar']) ? 1 : 0
                ]);
            }
        }

        return redirect()->route('navbar.secciones.index')
            ->with('ok', 'Sección guardada');
    }

    public function mostrar($id)
    {
        $seccion = NavbarSeccion::with('cuadros')->findOrFail($id);
        return view('navbar.secciones.mostrar', compact('seccion'));
    }

    public function editar($id)
    {
        $seccion = NavbarSeccion::with('cuadros')->findOrFail($id);
        return view('navbar.secciones.editar', compact('seccion'));
    }

    public function eliminar($id)
    {
        // ✅ eliminar cuadros polimórficos
        Cuadro::where('cuadrobable_id', $id)
              ->where('cuadrobable_type', NavbarSeccion::class)
              ->delete();

        // ✅ eliminar sección
        NavbarSeccion::where('id', $id)->delete();

        return back()->with('ok', 'Sección eliminada');
    }
}
