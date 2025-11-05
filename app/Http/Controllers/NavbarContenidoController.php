<?php

namespace App\Http\Controllers;

use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;
use Illuminate\Http\Request;

class NavbarContenidosController extends Controller
{
    // Mostrar formulario para crear un submenú
    public function crear($navbar_seccion_id)
    {
        $navbar_seccion = NavbarSeccion::findOrFail($navbar_seccion_id);
        return view('navbar.contenidos.crear', compact('navbar_seccion'));
    }

    // Guardar el submenú en la base de datos
    public function guardar(Request $request, $navbar_seccion_id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ruta' => 'nullable|string|max:255'
        ]);

        NavbarContenido::create([
            'navbar_seccion_id' => $navbar_seccion_id,
            'nombre' => $request->nombre,
            'ruta' => $request->ruta,
        ]);

        return redirect()->route('navbar.secciones.index')->with('success', 'Submenú agregado correctamente.');
    }

    // Mostrar formulario de edición
    public function editar($id)
    {
        $navbar_contenido = NavbarContenido::findOrFail($id);
        return view('navbar.contenidos.editar', compact('navbar_contenido'));
    }

    // Actualizar submenú
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'ruta' => 'nullable|string|max:255'
        ]);

        $navbar_contenido = NavbarContenido::findOrFail($id);
        $navbar_contenido->update([
            'nombre' => $request->nombre,
            'ruta' => $request->ruta,
        ]);

        return redirect()->route('navbar.secciones.index')->with('success', 'Submenú actualizado correctamente.');
    }

    // Eliminar submenú
    public function borrar($id)
    {
        $navbar_contenido = NavbarContenido::findOrFail($id);
        $navbar_contenido->delete();

        return redirect()->route('navbar.secciones.index')->with('success', 'Submenú eliminado correctamente.');
    }
}
