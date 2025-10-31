<?php

namespace App\Http\Controllers;

use App\Models\Secciones;
use Illuminate\Http\Request;

class SeccionesController extends Controller
{
    public function listado()
    {
        $secciones = Secciones::all(); 
        return view('secciones.listado', compact('secciones'));
    }

   
    public function crear()
    {
        return view('secciones.secciones'); 
    }

   
    public function guardar(Request $request)
    {
      $request->validate([
    'nombre' => 'required|string|max:255',
    'descripcion' => 'required',
]);


        Secciones::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion, 
        ]);

        return redirect()->route('secciones.listado')->with('success', 'Sección creada correctamente.');
    }

    public function editar($id)
    {
        $seccion = Secciones::findOrFail($id);
        return view('secciones.editar', compact('seccion'));
    }

    public function actualizar(Request $request, $id)
{
   $request->validate([
    'nombre' => 'required|string|max:255',
    'descripcion' => 'required',
]);


    $seccion = Secciones::findOrFail($id);
    $seccion->update([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
    ]);

    return redirect()->route('secciones.listado')->with('success', 'Sección actualizada correctamente');
}

    
    public function borrar($id)
    {
        $seccion = Secciones::findOrFail($id);
        $seccion->delete();

        return redirect()->route('secciones.listado')->with('success', 'Sección eliminada correctamente.');
    }

  
    public function mostrar($id)
    {
        $seccion = Secciones::with('contenidos')->findOrFail($id);
        $secciones = Secciones::all(); 
        return view('secciones.mostrar', compact('seccion', 'secciones'));
    }
}
