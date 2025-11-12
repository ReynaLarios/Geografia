<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;

class SeccionesController extends Controller
{
    /* ==========================================================
       LISTADO DE SECCIONES
    ========================================================== */
    public function listado()
    {
        $secciones = Seccion::all();

        return view('secciones.listado', [
            'secciones' => $secciones,
            'seccionActual' => null
        ]);
    }

    /* ==========================================================
       MOSTRAR SECCIÓN (CON CONTENIDOS Y CUADROS)
    ========================================================== */
    public function mostrar($id)
{
    $secciones = Seccion::all(); // Para la barra vertical
    $seccion = Seccion::with(['contenidos', 'cuadros'])->findOrFail($id);

    // Caso especial: videoteca
    if ($seccion->id == 24) {
        return redirect()->route('videoteca');
    }

    return view('secciones.mostrar', [
        'secciones' => $secciones,
        'seccion' => $seccion,
        'seccionActual' => $seccion // para la barra
    ]);
}


    /* ==========================================================
       CREAR NUEVA SECCIÓN
    ========================================================== */
    public function crear()
    {
        $secciones = Seccion::all();
        return view('secciones.secciones', compact('secciones'));
    }

    /* ==========================================================
       GUARDAR NUEVA SECCIÓN
    ========================================================== */
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Seccion::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección creada correctamente.');
    }

    /* ==========================================================
       EDITAR SECCIÓN
    ========================================================== */
    public function editar($id)
    {
        $secciones = Seccion::all();
        $seccion = Seccion::findOrFail($id);

        return view('secciones.editar', compact('secciones', 'seccion'));
    }

    /* ==========================================================
       ACTUALIZAR SECCIÓN
    ========================================================== */
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $seccion = Seccion::findOrFail($id);

        $seccion->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion
        ]);

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección actualizada correctamente.');
    }

    /* ==========================================================
       BORRAR SECCIÓN
    ========================================================== */
    public function borrar($id)
    {
        $seccion = Seccion::findOrFail($id);
        $seccion->delete();

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección eliminada correctamente.');
    }
}
