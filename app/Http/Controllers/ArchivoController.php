<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;

class ArchivoController extends Controller
{

    public function index()
    {
        $archivos = Archivo::latest()->get();
        return view('archivos.index', compact('archivos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'archivos.*' => 'required|file|max:10240', // max 10MB
            'archivable_type' => 'nullable|string',     // nombre del modelo
            'archivable_id' => 'nullable|integer',      // id del modelo
        ]);

        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $file) {
                $ruta = $file->store('archivos', 'public');

                Archivo::create([
                    'nombre_real' => $file->getClientOriginalName(),
                    'archivo' => basename($ruta),
                    'archivable_type' => $request->archivable_type,
                    'archivable_id' => $request->archivable_id,
                ]);
            }
        }

        return back()->with('success', 'Archivos subidos correctamente.');
    }

    // Eliminar archivo individual
    public function destroy(Archivo $archivo)
    {
        if ($archivo->archivo && Storage::disk('public')->exists('archivos/' . $archivo->archivo)) {
            Storage::disk('public')->delete('archivos/' . $archivo->archivo);
        }

        $archivo->delete();

        return back()->with('success', 'Archivo eliminado correctamente.');
    }

    // Guardar banner admin
    public function guardarBannerAdmin(Request $request)
    {
        $request->validate([
            'archivo' => 'required|image|max:10240', // 10MB
        ]);

        // Eliminar banner anterior si existe
        $bannerExistente = Archivo::where('ubicacion', 'banner_admin')->latest()->first();
        if ($bannerExistente && $bannerExistente->archivo) {
            if (Storage::disk('public')->exists('archivos/' . $bannerExistente->archivo)) {
                Storage::disk('public')->delete('archivos/' . $bannerExistente->archivo);
            }
            $bannerExistente->delete();
        }

        $file = $request->file('archivo');
        $ruta = $file->store('archivos', 'public');

        Archivo::create([
            'nombre_real' => $file->getClientOriginalName(),
            'archivo' => basename($ruta),
            'tipo' => $file->getClientOriginalExtension(),
            'ubicacion' => 'banner_admin',
        ]);

        return back()->with('success', 'Banner subido correctamente.');
    }
}
