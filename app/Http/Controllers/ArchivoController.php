<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Contenidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    // Mostrar todos los archivos
    public function index()
    {
        $archivos = Archivo::with('contenido')->latest()->get();
        $contenidos = Contenidos::all();
        return view('archivos.index', compact('archivos', 'contenidos'));
    }

    // Guardar archivo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'nullable|string|max:255', // puede ser null
            'archivo' => 'required|file|max:10240', // max 10MB
            'contenido_id' => 'nullable|exists:contenidos,id',
        ]);

        $file = $request->file('archivo');
        $ruta = $file->store('archivos', 'public'); // se guarda en storage/app/public/archivos

        Archivo::create([
            'nombre' => $request->nombre,                  // opcional
            'ruta' => $ruta,                               // obligatorio
            'tipo' => $file->getClientOriginalExtension(), // obligatorio
            'contenido_id' => $request->contenido_id,
        ]);

        return back()->with('success', 'Archivo subido correctamente.');
    }

    // Borrar archivo
    public function borrar($id)
    {
        $archivo = Archivo::findOrFail($id);

        if ($archivo->ruta && Storage::disk('public')->exists($archivo->ruta)) {
            Storage::disk('public')->delete($archivo->ruta);
        }

        $archivo->delete();

        return back()->with('success', 'Archivo eliminado correctamente.');
    }

    // Guardar banner admin
    public function guardarBannerAdmin(Request $request)
    {
        $request->validate([
            'archivo' => 'required|image|max:10240',
        ]);

        // Eliminar banner anterior si existe
        $bannerExistente = Archivo::where('ubicacion', 'banner_admin')->latest()->first();
        if ($bannerExistente && $bannerExistente->ruta) {
            if (Storage::disk('public')->exists($bannerExistente->ruta)) {
                Storage::disk('public')->delete($bannerExistente->ruta);
            }
            $bannerExistente->delete();
        }

        $file = $request->file('archivo');
        $ruta = $file->store('banners', 'public');

        Archivo::create([
            'nombre' => $file->getClientOriginalName(),
            'ruta' => $ruta,
            'tipo' => $file->getClientOriginalExtension(),
            'ubicacion' => 'banner_admin',
        ]);

        return back()->with('success', 'Banner subido correctamente.');
    }
}
