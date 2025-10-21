<?php

namespace App\Http\Controllers;

use App\Models\Secciones;
use Illuminate\Http\Request;

class SeccionesController extends Controller
{
    // Mostrar todas las secciones
     public function listar()
{
    $secciones = Secciones::all(); // todas las secciones
    return view('secciones.listado', compact('secciones'));
}

    // Mostrar formulario para crear
    public function crear()
    {
        return view('secciones.secciones');
    }

    // Guardar una nueva sección
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
        ]);

        Secciones::create($request->all());
        return redirect('/secciones/listar')->with('success', 'Sección creada correctamente.');
    }

    // Mostrar formulario para editar
    public function editar($id)
    {
        $seccion = Secciones::findOrFail($id);
        return view('secciones.editar', compact('seccion'));
    }

    // Actualizar
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string|max:255',
        ]);

        $seccion = Secciones::findOrFail($id);
        $seccion->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

        return redirect()->route('secciones.listar')->with('success', 'Sección actualizada correctamente');
    }

    // Borrar
    public function borrar($id)
    {
        $seccion = Secciones::findOrFail($id);
        $seccion->delete();
        return redirect()->route('secciones.listar')->with('success', 'Sección eliminada correctamente');
    }

    // Mostrar sección con su descripción

public function mostrar($id)
{
    $seccion = Secciones::with('contenidos')->findOrFail($id);
    $secciones = Secciones::all(); // para sidebar si quieres mostrar todas también
    return view('secciones.mostrar', compact('seccion', 'secciones'));
}


}
