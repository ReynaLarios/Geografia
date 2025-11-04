<?php

namespace App\Http\Controllers;

use App\Models\Secciones;
use App\Models\Videoteca;
use Illuminate\Http\Request;

class SeccionesController extends Controller
{
    
   public function listado()
{
    $secciones = \App\Models\Secciones::all(); // solo las secciones
    $videos = \App\Models\Videoteca::with('categoria')->get(); // todos los videos para la sección extra

    return view('secciones.listado', compact('secciones', 'videos'));
}


    // Crear nueva sección
    public function crear()
    {
        return view('secciones.secciones'); 
    }

    // Guardar nueva sección
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

    // Editar sección
    public function editar($id)
    {
        $seccion = Secciones::findOrFail($id);
        return view('secciones.editar', compact('seccion'));
    }

    // Actualizar sección
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

    // Mostrar una sección individual
public function mostrar($id)
{
    if($id == 24) {
        // Redirige a la videoteca
        return redirect()->route('secciones.videoteca');
    }

    $seccion = Secciones::with('contenidos')->findOrFail($id);
    return view('secciones.mostrar', compact('seccion'));
}

// Página de videoteca para la sección 24
public function videoteca()
{
    $videos = Videoteca::with('categoria')->get();
    return view('secciones.videoteca', compact('videos'));
}

   
}