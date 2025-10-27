<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archivo;
use App\Models\Contenido;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    // Listar archivos de un contenido
    public function listar($contenido_id)
    {
        $contenido = Contenido::findOrFail($contenido_id);
        $archivos = $contenido->archivos;
        return view('archivos.listado', compact('contenido', 'archivos'));
    }

    // Formulario para subir archivo
    public function crear($contenido_id)
    {
        $contenido = Contenido::findOrFail($contenido_id);
        return view('archivos.formulario', compact('contenido'));
    }

    // Guardar archivo
    public function guardar(Request $request, $contenido_id)
    {$request->validate([
    'archivo' => 'required|mimes:jpg,jpeg,png,gif,mp4,avi,mov,pdf,doc,docx,txt|max:10240',
]);


        $contenido = Contenido::findOrFail($contenido_id);
        $file = $request->file('archivo');
        $ruta = $file->store('archivos', 'public');

        Archivo::create([
            'nombre' => $file->getClientOriginalName(),
            'ruta' => $ruta,
            'tipo' => $file->getClientOriginalExtension(),
            'contenido_id' => $contenido->id,
        ]);

        return redirect()
            ->route('archivos.listar', $contenido_id)
            ->with('success', 'Archivo subido correctamente');
    }

    // Eliminar archivo
    public function borrar($id)
    {
        $archivo = Archivo::findOrFail($id);
        Storage::disk('public')->delete($archivo->ruta);
        $contenido_id = $archivo->contenido_id;
        $archivo->delete();

        return redirect()
            ->route('archivos.listar', $contenido_id)
            ->with('success', 'Archivo eliminado');
    }

    // Descargar archivo
    public function descargar($id)
    {
        $archivo = Archivo::findOrFail($id);
        return Storage::disk('public')->download($archivo->ruta, $archivo->nombre);
    }
}
