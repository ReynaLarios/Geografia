<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secciones;

class SeccionesController extends Controller
{
    public function crear() 
    {
        return view('secciones.secciones');
    }

    public function guardar(Request $req)
    {
        $req->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $seccion = new Secciones();
        $seccion->nombre = $req->nombre;
        $seccion->descripcion = $req->descripcion;

        $seccion->save();

        return redirect('/secciones/listar')->with('success', 'Sección creada correctamente');
    }

    public function listar()
    {
        $secciones = Secciones::all();
        return view('secciones.listado', compact('secciones'));
    }

    public function editar($id)
    {
        $seccion = Secciones::findOrFail($id);
        return view('secciones.editar', compact('seccion'));
    }

    public function actualizar(Request $req, $id)
    {
        $req->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        $seccion = Secciones::findOrFail($id);
        $seccion->nombre = $req->nombre;
        $seccion->descripcion = $req->descripcion;

        $seccion->save();

        return redirect()->back()->with('success', 'Sección actualizada correctamente');
    }

    public function mostrar($id)
    {
        $seccion = Secciones::findOrFail($id);
        return view('secciones.mostrar', compact('seccion'));
    }

    public function borrar($id)
    {
        $seccion = Secciones::findOrFail($id);
        $seccion->delete();

        return view('secciones.listar')->with('success', 'Sección eliminada correctamente');
    }
}
