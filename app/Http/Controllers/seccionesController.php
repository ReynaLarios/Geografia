<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Contenido;

class SeccionesController extends Controller
{
    public function edit($id)
    {
        $seccion = Seccion::findOrFail($id);
        $contenidos = Contenido::all(); // para mostrar en select
        return view('secciones.editar', compact('seccion', 'contenidos'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'contenido_id' => 'nullable|exists:contenidos,id',
        ]);

        $seccion = Seccion::findOrFail($id);
        $seccion->nombre = $request->nombre;
        $seccion->descripcion = $request->descripcion;
        $seccion->contenido_id = $request->contenido_id;
        $seccion->save();

        return redirect()->back()->with('success', 'Sección actualizada correctamente.');
    }
}
