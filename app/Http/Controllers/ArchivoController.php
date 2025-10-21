<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\archivos;
use App\Models\Contenidos;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    // Listar archivos de un contenido
    public function listar($contenido_id)
    {
        $contenido = Contenidos::findOrFail($contenido_id);
        $archivos = $contenido->archivos;
        return view('archivos.listado', compact('contenido', 'archivos'));
    }

    // Formulario subir archivo
    public function crear($contenido_id)
    {
        $contenido = Contenidos::findOrFail($contenido_id);
        return view('archivos.formulario', compact('contenido'));
    }

    // Guardar archivo
    public function guardar(Request $request, $contenido_id)
    {
        $request->validate([
            'archivo' => 'required|file|max:10240', // 10 MB
        ]);

        $contenido = Contenidos::findOrFail($contenido_id);
        $file = $request->file('archivo');
        $ruta = $file->store('archivos', 'public');
        $tipo = $file->getClientOriginalExtension();
        $nombre = $file->getClientOriginalName();

        archivos::create([
            'nombre' => $nombre,
            'ruta' => $ruta,
            'tipo' => $tipo,
            'contenido_id' => $contenido->id,
        ]);

        return redirect()->route('archivos.listar', $contenido_id)->with('success', 'Archivo subido correctamente');
    }

    // Borrar archivo
    public function borrar($id)
    {
        $archivo = archivos::findOrFail($id);
        Storage::disk('public')->delete($archivo->ruta);
        $contenido_id = $archivo->contenido_id;
        $archivo->delete();

        return redirect()->route('archivos.listar', $contenido_id)->with('success', 'Archivo eliminado');
    }

    // Descargar archivo
    public function descargar($id)
    {
        $archivo = archivos::findOrFail($id);
        return Storage::disk('public')->download($archivo->ruta, $archivo->nombre);
    }
}
