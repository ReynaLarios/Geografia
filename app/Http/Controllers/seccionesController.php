<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Cuadro;
use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Log;


class SeccionesController extends Controller
{
    
    public function listado()
    {
        $secciones = Seccion::all();
        return view('secciones.listado', compact('secciones'));
    }

 
    public function crear()
    {
        return view('secciones.secciones'); 
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre'      => 'required|string',
            'descripcion' => 'nullable|string',
            'imagen'      => 'nullable|image',
            'video'       => 'nullable|mimes:mp4,avi,mov|max:102400',
        ]);

        $seccion = Seccion::create([
            'nombre'      => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen'      => $request->hasFile('imagen') ? $request->imagen->store('secciones', 'public') : null,
            'video'       => $request->hasFile('video')  ? $request->video->store('videos', 'public') : null,
            'slug'        => Str::slug($request->nombre) . '-' . uniqid(),
        ]);

        $this->guardarArchivos($request, $seccion);
        $this->guardarCuadros($request, $seccion);

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección creada correctamente');
    }

  
    public function mostrar($slug)
    {
        $seccion = Seccion::with(['archivos', 'cuadros.archivos'])
                          ->where('slug', $slug)
                          ->firstOrFail();

        return view('secciones.mostrar', compact('seccion'));
    }

   
    public function editar($slug)
    {
        $seccion = Seccion::with(['archivos', 'cuadros.archivos'])
                          ->where('slug', $slug)
                          ->firstOrFail();
        return view('secciones.editar', compact('seccion'));
    }

   
    public function actualizar(Request $request, $slug)
    {
        $seccion = Seccion::with(['archivos', 'cuadros.archivos'])
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
        if ($request->hasFile('video')) {
            $this->eliminarArchivoFisico($seccion->video);
            $seccion->video = $request->video->store('videos', 'public');
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

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección actualizada correctamente');
    }

    public function borrar($slug)
    {
        $seccion = Seccion::with(['archivos', 'cuadros.archivos'])
                          ->where('slug', $slug)
                          ->firstOrFail();

        $this->eliminarArchivoFisico($seccion->imagen);
        $this->eliminarArchivoFisico($seccion->video);

        $seccion->archivos->each(function($archivo) {
            $this->eliminarArchivoFisico($archivo->ruta);
            $archivo->delete();
        });

        $seccion->cuadros->each(function($cuadro) {
            $cuadro->archivos->each(function($archivo) {
                $this->eliminarArchivoFisico($archivo->ruta);
                $archivo->delete();
            });
            $cuadro->delete();
        });

        $seccion->delete();

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección eliminada correctamente');
    }

    
    private function guardarArchivos(Request $request, $seccion)
    {
        $archivos = $request->file('archivos');
        if (!$archivos || !is_array($archivos)) return;

        $allowedExtensions = ['jpg','jpeg','png','pdf','docx','mp4','mp3'];

        foreach ($archivos as $archivo) {
            if (!$archivo || !$archivo->isValid()) continue;
            if (!in_array(strtolower($archivo->getClientOriginalExtension()), $allowedExtensions)) continue;

            $ruta = $archivo->store('archivos', 'public');

            $seccion->archivos()->create([
                'nombre' => $archivo->getClientOriginalName() ?: 'sin_nombre',
                'ruta'   => $ruta,
                'tipo'   => $archivo->getClientOriginalExtension() ?: 'desconocido',
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

            if (empty($tituloLimpio) && empty($autorLimpio) && !$hayArchivo) continue;

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
