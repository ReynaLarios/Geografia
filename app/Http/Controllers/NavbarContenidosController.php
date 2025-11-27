<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NavbarContenido;
use App\Models\NavbarSeccion;
use App\Models\Archivo;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;

class NavbarContenidosController extends Controller
{
  
    public function index()
    {
        $contenidos = NavbarContenido::with('seccion')->get();
        return view('navbar.contenidos.index', compact('contenidos'));
    }

    public function crear(Request $request)
    {
        $secciones = NavbarSeccion::all();

        return view('navbar.contenidos.crear', [
            'secciones' => $secciones,
            'seccionId' => $request->seccion_id ?? null
        ]);
    }

    
   public function guardar(Request $request)
    {
        $request->validate([
            'navbar_seccion_id' => 'required|exists:navbar_secciones,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadros' => 'nullable|array',
        ]);

        // Imagen principal
        $rutaImagen = $request->hasFile('imagen') ? $request->file('imagen')->store('navbar_contenidos', 'public') : null;

        // Crear contenido (slug automático en el modelo)
        $contenido = NavbarContenido::create([
            'navbar_seccion_id' => $request->navbar_seccion_id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $rutaImagen,
        ]);

        // Archivos adicionales
        foreach ($request->file('archivos') ?? [] as $archivo) {
            $contenido->archivos()->create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta' => $archivo->store('archivos_navbar', 'public'),
                'tipo' => $archivo->getClientOriginalExtension(),
            ]);
        }

        // Cuadros
        foreach ($request->cuadros ?? [] as $cuadroData) {
            if (empty($cuadroData['titulo']) && empty($cuadroData['autor']) && empty($cuadroData['archivo'])) continue;

            $rutaArchivo = isset($cuadroData['archivo']) ? $cuadroData['archivo']->store('cuadros', 'public') : null;

            $cuadro = $contenido->cuadros()->create([
                'titulo' => $cuadroData['titulo'] ?? null,
                'autor' => $cuadroData['autor'] ?? null,
                'archivo' => $rutaArchivo,
            ]);

            foreach ($cuadroData['archivos'] ?? [] as $archivoExtra) {
                $cuadro->archivos()->create([
                    'nombre' => $archivoExtra->getClientOriginalName(),
                    'ruta' => $archivoExtra->store('archivos/cuadros', 'public'),
                    'tipo' => $archivoExtra->getClientOriginalExtension(),
                ]);
            }
        }

        return redirect()->route('navbar.contenidos.index')
                         ->with('success', 'Contenido creado correctamente.');
    }

  
    public function editar($id)
    {
        $contenido = NavbarContenido::with(['seccion', 'archivos', 'cuadros.archivos'])->findOrFail($id);
        $secciones = NavbarSeccion::all();

        return view('navbar.contenidos.editar', compact('contenido', 'secciones'));
    }


    public function actualizar(Request $request, $id)
    {
        $contenido = NavbarContenido::with(['cuadros.archivos'])->findOrFail($id);

        $request->validate([
            'navbar_seccion_id' => 'required|exists:navbar_secciones,id',
            'titulo' => 'required|string|max:255',
        ]);


        if ($request->hasFile('imagen')) {
            if ($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)) {
                Storage::disk('public')->delete($contenido->imagen);
            }
            $contenido->imagen = $request->file('imagen')->store('navbar_contenidos', 'public');
        }

        $contenido->navbar_seccion_id = $request->navbar_seccion_id;
        $contenido->titulo = $request->titulo;
        $contenido->descripcion = $request->descripcion;
        $contenido->save();

        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $ruta = $archivo->store('archivos_navbar', 'public');
                $contenido->archivos()->create([
                    'nombre' => $archivo->getClientOriginalName(),
                    'ruta' => $ruta,
                    'tipo' => $archivo->getClientOriginalExtension(),
                ]);
            }
        }

      
        if ($request->has('cuadros')) {
            $idsRecibidos = collect($request->cuadros)->pluck('id')->filter()->all();
            $idsExistentes = $contenido->cuadros->pluck('id')->all();

            $paraBorrar = array_diff($idsExistentes, $idsRecibidos);
            foreach ($paraBorrar as $idBorrar) {
                $cuadro = Cuadro::find($idBorrar);
                if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                    Storage::disk('public')->delete($cuadro->archivo);
                }
                foreach ($cuadro->archivos as $archivo) {
                    if (Storage::disk('public')->exists($archivo->ruta)) {
                        Storage::disk('public')->delete($archivo->ruta);
                    }
                    $archivo->delete();
                }
                $cuadro->delete();
            }

            foreach ($request->cuadros as $cuadroData) {
                if (!empty($cuadroData['id'])) {
                    $cuadro = Cuadro::find($cuadroData['id']);
                    $cuadro->titulo = $cuadroData['titulo'] ?? $cuadro->titulo;
                    $cuadro->autor = $cuadroData['autor'] ?? $cuadro->autor;

                    if (isset($cuadroData['archivo'])) {
                        if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                            Storage::disk('public')->delete($cuadro->archivo);
                        }
                        $cuadro->archivo = $cuadroData['archivo']->store('cuadros', 'public');
                    }

                    $cuadro->save();
                } else {
                    $rutaArchivo = isset($cuadroData['archivo']) ? $cuadroData['archivo']->store('cuadros', 'public') : null;
                    $cuadro = $contenido->cuadros()->create([
                        'titulo' => $cuadroData['titulo'] ?? null,
                        'autor' => $cuadroData['autor'] ?? null,
                        'archivo' => $rutaArchivo
                    ]);
                }

               
                if (isset($cuadroData['archivos'])) {
                    foreach ($cuadroData['archivos'] as $archivoExtra) {
                        $rutaExtra = $archivoExtra->store('archivos/cuadros', 'public');
                        $cuadro->archivos()->create([
                            'nombre' => $archivoExtra->getClientOriginalName(),
                            'ruta' => $rutaExtra,
                            'tipo' => $archivoExtra->getClientOriginalExtension(),
                        ]);
                    }
                }
            }
        }

        return redirect()->route('navbar.contenidos.index')
            ->with('success', 'Contenido actualizado correctamente.');
    }

 
    public function borrar($id)
    {
        $contenido = NavbarContenido::with(['archivos', 'cuadros.archivos'])->findOrFail($id);

     
        if ($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)) {
            Storage::disk('public')->delete($contenido->imagen);
        }

     
        foreach ($contenido->archivos as $archivo) {
            if (Storage::disk('public')->exists($archivo->ruta)) {
                Storage::disk('public')->delete($archivo->ruta);
            }
            $archivo->delete();
        }

        
        foreach ($contenido->cuadros as $cuadro) {
            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }
            foreach ($cuadro->archivos as $archivo) {
                if (Storage::disk('public')->exists($archivo->ruta)) {
                    Storage::disk('public')->delete($archivo->ruta);
                }
                $archivo->delete();
            }
            $cuadro->delete();
        }

        $contenido->delete();

        return redirect()->route('navbar.contenidos.index')
            ->with('success', 'Contenido eliminado correctamente.');
    }

    public function mostrar($id)
{

    $contenido = NavbarContenido::with(['seccion', 'archivos', 'cuadros.archivos'])->findOrFail($id);

    return view('navbar.contenidos.mostrar', compact('contenido'));
}

}
