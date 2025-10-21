<?php

namespace App\Http\Controllers;

use App\Models\Contenidos;
use App\Models\Secciones;
use Illuminate\Http\Request;

class ContenidosController extends Controller
{
    // Mostrar todos los contenidos
    public function listar()
    {
        $contenidos = Contenidos::with('seccion')->get();
        $secciones = Secciones::all();
        return view('contenidos.listado', compact('contenidos', 'secciones'));
    }

    // Mostrar formulario para crear contenido
    public function crear(Request $request)
    {
        $secciones = Secciones::all();
        return view('contenidos.contenidos', compact('secciones'));
    }

    // Guardar un nuevo contenido
    public function guardar(Request $request)
    {
        $request->validate([
            'seccion_id' => 'required|exists:secciones,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $datos = $request->only(['seccion_id', 'titulo', 'descripcion']);

        // Subida de imagen si existe
        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('contenidos', 'public');
        }

        Contenidos::create($datos);

        return redirect()->route('contenidos.listar')->with('success', 'Contenido creado correctamente');
    }

    // Mostrar formulario para editar contenido
    public function editar($id)
    {
        $contenido = Contenidos::findOrFail($id);
        $secciones = Secciones::all();
        return view('contenidos.contenidos', compact('contenido', 'secciones'));
    }

    // Actualizar contenido
    public function actualizar(Request $request, $id)
    {
        $contenido = Contenidos::findOrFail($id);

        $request->validate([
            'seccion_id' => 'required|exists:secciones,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048'
        ]);

        $datos = $request->only(['seccion_id', 'titulo', 'descripcion']);

        // Subida de imagen si existe
        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('contenidos', 'public');
        }

        $contenido->update($datos);

        return redirect()->route('contenidos.listar')->with('success', 'Contenido actualizado correctamente');
    }

    // Mostrar un contenido específico
   public function mostrar($id) {
    $contenido = Contenidos::with('seccion')->findOrFail($id);
    $seccion = $contenido->seccion; // para sidebar
    return view('contenidos.mostrar', compact('contenido', 'seccion'));
}


    // Borrar contenido
    public function borrar($id)
{
    $contenido = Contenidos::findOrFail($id); // Encontrar el contenido
    $contenido->delete(); // Borrar el contenido

    // Redirigir a la página de la sección a la que pertenecía
    return redirect()->route('secciones.{id}.mostrar', $contenido->seccion_id)
                     ->with('success', 'Contenido eliminado correctamente');
}

}
