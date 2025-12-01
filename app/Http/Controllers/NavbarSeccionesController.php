<?php

namespace App\Http\Controllers;

use App\Models\Archivo;
use Illuminate\Http\Request;
use App\Models\NavbarSeccion;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;

class NavbarSeccionesController extends Controller
{
   
    public function index()
    {
        $secciones = NavbarSeccion::with(['cuadros.archivos', 'archivos'])->get();
        return view('navbar.secciones.index', compact('secciones'));
    }

    public function crear()
    {
        return view('navbar.secciones.crear');
    }



public function guardar(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:5120',
        'archivos.*' => 'nullable|file|max:10240',
        'cuadros' => 'nullable|array',
    ]);

    $rutaImagen = $request->hasFile('imagen') ? $request->file('imagen')->store('navbar_secciones', 'public') : null;

    
    $slugBase = Str::slug($request->nombre);
    $slug = $slugBase;
    $contador = 1;
    while (NavbarSeccion::where('slug', $slug)->exists()) {
        $slug = $slugBase . '-' . $contador;
        $contador++;
    }

    $seccion = NavbarSeccion::create([
        'nombre' => $request->nombre,
        'slug' => $slug,
        'descripcion' => $request->descripcion,
        'imagen' => $rutaImagen,
    ]);

    $this->guardarArchivos($request, $seccion);
    $this->guardarCuadros($request, $seccion);

    return redirect()->route('navbar.secciones.index')
                     ->with('success', 'Sección creada correctamente.');
}


  
    public function editar($slug)
    {
        $seccion = NavbarSeccion::with(['archivos', 'cuadros.archivos'])
                          ->where('slug', $slug)
                          ->firstOrFail();
        return view('navbar.secciones.editar', compact('seccion'));
    }

   
    public function actualizar(Request $request, $slug)
    {
        $seccion =  NavbarSeccion::with(['archivos', 'cuadros.archivos'])
                          ->where('slug', $slug)
                          ->firstOrFail();

        $seccion->update([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
        ]);

      
        if ($request->eliminar_imagen && $seccion->imagen) {
            $this->eliminarArchivoFisico($seccion->imagen);
            $seccion->imagen = null;
        }
        if ($request->hasFile('imagen')) {
            $this->eliminarArchivoFisico($seccion->imagen);
            $seccion->imagen = $request->imagen->store('secciones', 'public');
        }

        
        if ($request->eliminar_video && $seccion->video) {
            $this->eliminarArchivoFisico($seccion->video);
            $seccion->video = null;
        }
        

        $seccion->save();

        
        if ($request->archivos_eliminados) {
            $ids = is_array($request->archivos_eliminados) ? $request->archivos_eliminados : json_decode($request->archivos_eliminados, true);
            if (is_array($ids)) {
                foreach ($ids as $archivoId) {
                    $archivo = Archivo::find($archivoId);
                    if ($archivo) {
                        $this->eliminarArchivoFisico($archivo->ruta);
                        $archivo->delete();
                    }
                }
            }
        }

        $this->guardarArchivos($request, $seccion);
        $this->guardarCuadros($request, $seccion);

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'seccion actualizada correctamente');
 }

public function borrarArchivo($archivoId)
{
    $archivo = \App\Models\Archivo::findOrFail($archivoId);

    if ($archivo->ruta && Storage::disk('public')->exists($archivo->ruta)) {
        Storage::disk('public')->delete($archivo->ruta);
    }

    $archivo->delete();

    return back()->with('success', 'Archivo eliminado correctamente.');
}

public function borrarImagen($slug) 
{
    $seccion = NavbarSeccion::findOrFail($slug);

    if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
        Storage::disk('public')->delete($seccion->imagen);
    }

    $seccion->imagen = null;
    $seccion->save();

    return back()->with('success', 'Imagen eliminada correctamente.');
}


public function borrar($slug)
{
    $seccion = NavbarSeccion::where('slug', $slug)
                          ->firstOrFail();
  
    if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
        Storage::disk('public')->delete($seccion->imagen);
    }

   
    $seccion->delete();

    return back()->with('success', 'Sección eliminada correctamente.');
}

    

    public function mostrar($idOrSlug)
    {
        if (is_numeric($idOrSlug)) {
           
            $seccion = NavbarSeccion::with(['cuadros.archivos', 'archivos'])->findOrFail($idOrSlug);
        } else {
          
            $seccion = NavbarSeccion::with(['cuadros.archivos', 'archivos'])
                ->where('slug', $idOrSlug)
                ->firstOrFail();
        }

        return view('navbar.secciones.mostrar', compact('seccion'));
    }


    private function guardarArchivos(Request $request, $seccion)
    {
        foreach ($request->file('archivos') ?? [] as $archivo) {
            $seccion->archivos()->create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta' => $archivo->store('archivos_seccion', 'public'),
                'tipo' => $archivo->getClientOriginalExtension()
            ]);
        }
    }

     private function guardarCuadros(Request $request, $seccion)
    {
        $ids = $request->cuadro_id ?? [];
        $titulos = $request->cuadro_titulo ?? [];
        $autores = $request->cuadro_autor ?? [];
        $archivos = $request->file('cuadro_archivo') ?? [];

        $idsExistentes = $seccion->cuadros()->pluck('id')->toArray();
        $idsRecibidos = [];

        foreach ($titulos as $i => $titulo) {
            $id = intval($ids[$i] ?? 0);
            $idsRecibidos[] = $id;

            $tituloLimpio = trim($titulo ?? '');
            $autorLimpio  = trim($autores[$i] ?? '');
            $archivo      = $archivos[$i] ?? null;
            $hayArchivo   = $archivo && $archivo->isValid();

           if ($tituloLimpio === '' && $autorLimpio === '' && !$hayArchivo) continue;


            if ($id > 0) {
                $cuadro = Cuadro::find($id);
                if (!$cuadro) continue;

                $cuadro->update([
                    'titulo' => $tituloLimpio,
                    'autor'  => $autorLimpio,
                ]);

                if ($hayArchivo) {
                    $cuadro->archivos->each(function($archivoExistente){
                        $this->eliminarArchivoFisico($archivoExistente->ruta);
                        $archivoExistente->delete();
                    });

                    $cuadro->archivos()->create([
                        'nombre' => $archivo->getClientOriginalName(),
                        'ruta'   => $archivo->store('cuadros', 'public'),
                        'tipo'   => $archivo->getClientOriginalExtension(),
                    ]);
                }

                continue;
            }

            $cuadro = $seccion->cuadros()->create([
                'titulo' => $tituloLimpio,
                'autor'  => $autorLimpio,
            ]);

            if ($hayArchivo) {
                $cuadro->archivos()->create([
                    'nombre' => $archivo->getClientOriginalName(),
                    'ruta'   => $archivo->store('cuadros', 'public'),
                    'tipo'   => $archivo->getClientOriginalExtension(),
                ]);
            }
        }

        $paraBorrar = array_diff($idsExistentes, $idsRecibidos);
        foreach ($paraBorrar as $idBorrar) {
            $cuadro = Cuadro::find($idBorrar);
            if ($cuadro) {
                $cuadro->archivos->each(function($archivo) {
                    $this->eliminarArchivoFisico($archivo->ruta);
                    $archivo->delete();
                });
                $cuadro->delete();
            }
        }
    }

 
    private function eliminarArchivoFisico($ruta)
    {
        if ($ruta && Storage::disk('public')->exists($ruta)) {
            Storage::disk('public')->delete($ruta);
        } else if ($ruta) {
            Log::warning("Archivo no encontrado para eliminar: {$ruta}");

        }
    }
}
