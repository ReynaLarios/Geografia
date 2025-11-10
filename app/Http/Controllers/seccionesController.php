<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;

class SeccionesController extends Controller
{
    public function listado()
    {
        $secciones = Seccion::all();

        return view('secciones.listado', [
            'secciones' => $secciones,
            'seccionActual' => null 
        ]);
    }

    public function mostrar($id)
    {
        $secciones = Seccion::all();
        $seccion = Seccion::with('contenidos')->findOrFail($id);

        
        if ($seccion->id == 24) {
            return redirect()->route('videoteca');
        }

        return view('secciones.mostrar', [
            'secciones' => $secciones,
            'seccion' => $seccion,
            'seccionActual' => $seccion 
        ]);
    }


    public function crear()
    {
        $secciones = Seccion::all(); 
        return view('secciones.secciones', compact('secciones'));
    }

 
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
        ]);

        Seccion::create($request->all());

        return redirect()->route('secciones.listado')->with('success', 'Sección creada correctamente.');
    }

    public function editar($id)
    {
        $secciones = Seccion::all(); 
        $seccion = Seccion::findOrFail($id);

        return view('secciones.editar', compact('secciones', 'seccion'));
    }


    public function actualizar(Request $request, $id)
    {
        $seccion = Seccion::findOrFail($id);
        $seccion->update($request->all());

        return redirect()->route('secciones.listado')->with('success', 'Sección actualizada.');
    }

   
    public function borrar($id)
    {
        $seccion = Seccion::findOrFail($id);
        $seccion->delete();

        return redirect()->route('secciones.listado')->with('success', 'Sección eliminada.');
    }
}
