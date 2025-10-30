<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use App\Models\Contenido;
use App\Models\Contenidos;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{
    // Mostrar listado de archivos (panel admin)
    public function index()
    {
        $archivos = Archivo::with('contenido')->latest()->get();
        $contenidos = Contenidos::all();
        return view('archivos.index', compact('archivos', 'contenidos'));
    }

    // Subir archivo
    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'archivo' => 'required|file|max:10240',
            'contenido_id' => 'nullable|exists:contenidos,id',
        ]);

        $file = $request->file('archivo');
       $ruta = $file->move(public_path('archivos'), $file->getClientOriginalName());

        Archivo::create([
            'nombre' => $request->nombre,
            'ruta' => $ruta,
            'tipo' => $file->getClientOriginalExtension(),
            'contenido_id' => $request->contenido_id,
        ]);

        return back()->with('success', 'Archivo subido correctamente.');
    }

    // Eliminar archivo
   public function borrar($id)
{
    $archivo = Archivo::findOrFail($id);

    if (Storage::exists($archivo->ruta)) {
        Storage::delete($archivo->ruta);
    }

    $archivo->delete();

    return back()->with('success', 'Archivo eliminado correctamente.');
}


public function guardarBannerAdmin(Request $request)
{
    $request->validate([
        'archivo' => 'required|image|max:10240', // máximo 10MB
    ]);

    // Si ya hay un banner, borrarlo
    $bannerExistente = Archivo::where('ubicacion', 'banner_admin')->latest()->first();
    if($bannerExistente){
        if (Storage::disk('public')->exists($bannerExistente->ruta)) {
            Storage::disk('public')->delete($bannerExistente->ruta);
        }
        $bannerExistente->delete();
    }

    // Subir nueva imagen
    $file = $request->file('archivo');
    $ruta = $file->store('banners', 'public');

    // Guardar en BD
    $banner = Archivo::create([
        'nombre' => $file->getClientOriginalName(),
        'ruta' => $ruta,
        'ubicacion' => 'banner_admin',
    ]);

    return back()->with('success', 'Banner subido correctamente.');
}

}
