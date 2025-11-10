<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;

class SeccionesController extends Controller
{
    // Listado general de secciones
    public function listado()
    {
        $secciones = Seccion::all();

        return view('secciones.listado', [
            'secciones' => $secciones,
            'seccionActual' => null // Para el sidebar
        ]);
    }

    // Mostrar una sección con sus contenidos
    public function mostrar($id)
    {
        $secciones = Seccion::all(); // Para el sidebar
        $seccion = Seccion::with('contenidos')->findOrFail($id);

        // Si es Videoteca, redirige directo
        if ($seccion->id == 24) {
            return redirect()->route('videoteca');
        }

        return view('secciones.mostrar', [
            'secciones' => $secciones,
            'seccion' => $seccion,
            'seccionActual' => $seccion // Para el sidebar: mostrar contenidos de esta sección
        ]);
    }

    // Formulario para crear nueva sección
    public function crear()
    {
        $secciones = Seccion::all(); // sidebar
        return view('secciones.secciones', compact('secciones'));
    }

    // Guardar nueva sección
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Seccion::create($request->all());

        return redirect()->route('secciones.listado')->with('success', 'Sección creada correctamente.');
    }

    // Formulario para editar sección
    public function editar($id)
    {
        $secciones = Seccion::all(); // sidebar
        $seccion = Seccion::findOrFail($id);

        return view('secciones.editar', compact('secciones', 'seccion'));
    }

    // Actualizar sección
    public function actualizar(Request $request, $id)
    {
        $seccion = Seccion::findOrFail($id);
        $seccion->update($request->all());

        return redirect()->route('secciones.listado')->with('success', 'Sección actualizada.');
    }

    // Borrar sección
    public function borrar($id)
    {
        $seccion = Seccion::findOrFail($id);
        $seccion->delete();

        return redirect()->route('secciones.listado')->with('success', 'Sección eliminada.');
    }
}
