<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Contenidos;

class ContenidosController extends Controller
{
    public function edit($id)
    {
        $contenido = Contenidos::findOrFail($id);
        return view('contenidos.editar', compact('contenido'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'archivo_id' => 'nullable|integer',
        ]);

        $contenido = Contenidos::findOrFail($id);
        $contenido->titulo = $request->titulo;
        $contenido->descripcion = $request->descripcion;
        $contenido->archivo_id = $request->archivo_id;
        $contenido->save();

        return redirect()->back()->with('success', 'Contenido actualizado correctamente.');
    }
}
