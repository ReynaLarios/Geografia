<?php

namespace App\Http\Controllers;

use App\Models\Contenidos;
use App\Models\Seccion;
use App\Models\Archivo;
use App\Models\Cuadro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContenidosController extends Controller
{
    public function listado()
    {
        $contenidos = Contenidos::with(['seccion', 'archivos', 'cuadros'])->get();
        return view('Contenidos.listado', compact('contenidos'));
    }

   
    public function crear()
    {
        $secciones = Seccion::all();
        return view('Contenidos.contenidos', compact('secciones'));
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'seccion_id' => 'required|exists:secciones,id',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadro_titulo.*' => 'nullable|string|max:255',
            'cuadro_autor.*' => 'nullable|string|max:255',
            'cuadro_archivo.*' => 'nullable|file|max:5120',
            'cuadro_id.*' => 'nullable|integer',
        ]);

        $datos = $request->only(['titulo', 'descripcion', 'seccion_id']);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('contenidos', 'public');
        }

        $contenido = Contenidos::create($datos);

        $this->guardarArchivos($request, $contenido);
        $this->guardarCuadros($request, $contenido);

        return redirect()->route('contenidos.listado')->with('success', 'Contenido creado correctamente.');
    }

    
    public function editar($id)
    {
        $contenido = Contenidos::with(['archivos', 'cuadros'])->findOrFail($id);
        $secciones = Seccion::all();
        return view('Contenidos.editar', compact('contenido', 'secciones'));
    }

    
    public function actualizar(Request $request, $id)
    {
        $contenido = Contenidos::with(['archivos', 'cuadros'])->findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
          
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadro_titulo.*' => 'nullable|string|max:255',
            'cuadro_autor.*' => 'nullable|string|max:255',
            'cuadro_archivo.*' => 'nullable|file|max:5120',
            'cuadro_id.*' => 'nullable|integer',
        ]);

       
        $datos = [
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
        ];

     
        if ($request->hasFile('imagen')) {
            if ($contenido->imagen) Storage::disk('public')->delete($contenido->imagen);

            $datos['imagen'] = $request->file('imagen')->store('contenidos', 'public');
        } elseif ($request->eliminar_imagen) {
            if ($contenido->imagen) Storage::disk('public')->delete($contenido->imagen);

            $datos['imagen'] = null;
        }

        $contenido->update($datos);

        if ($request->archivos_eliminados) {
            foreach ($request->archivos_eliminados as $archivoId) {
                $archivo = Archivo::find($archivoId);
                if ($archivo) {
                    if ($archivo->ruta) Storage::disk('public')->delete($archivo->ruta);
                    $archivo->delete();
                }
            }
        }

       
        $this->guardarArchivos($request, $contenido);

     
        if ($request->cuadro_archivo_eliminado) {
            foreach ($request->cuadro_archivo_eliminado as $cuadroId) {
                $cuadro = Cuadro::find($cuadroId);
                if ($cuadro && $cuadro->archivo) {
                    Storage::disk('public')->delete($cuadro->archivo);
                    $cuadro->archivo = null;
                    $cuadro->save();
                }
            }
        }

        
        $this->guardarCuadros($request, $contenido);

        return redirect()->route('contenidos.listado')->with('success', 'Contenido actualizado correctamente.');
    }


    public function borrar($id)
    {
        $contenido = Contenidos::with(['archivos', 'cuadros'])->findOrFail($id);

      
        foreach ($contenido->archivos as $archivo) {
            if ($archivo->ruta) Storage::disk('public')->delete($archivo->ruta);
            $archivo->delete();
        }

       
        foreach ($contenido->cuadros as $cuadro) {
            if ($cuadro->archivo) Storage::disk('public')->delete($cuadro->archivo);
            $cuadro->delete();
        }

      
        if ($contenido->imagen) Storage::disk('public')->delete($contenido->imagen);

        $contenido->delete();

        return redirect()->route('contenidos.listado')->with('success', 'Contenido eliminado correctamente.');
    }

    public function mostrar($id)
    {
        $contenido = Contenidos::with(['seccion', 'archivos', 'cuadros'])->findOrFail($id);
        return view('Contenidos.mostrar', compact('contenido'));
    }

   
    private function guardarArchivos(Request $request, $contenido)
    {
        $archivos = $request->file('archivos') ?? [];

        foreach ($archivos as $archivo) {
            if (!$archivo || !$archivo->isValid()) continue;

            $ruta = $archivo->store('archivos', 'public');

            $contenido->archivos()->create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta' => $ruta,
                'tipo' => $archivo->getClientOriginalExtension(),
            ]);
        }
    }

    private function guardarCuadros(Request $request, $contenido)
    {
        $ids = $request->cuadro_id ?? [];
        $titulos = $request->cuadro_titulo ?? [];
        $autores = $request->cuadro_autor ?? [];
        $archivos = $request->file('cuadro_archivo') ?? [];

        $idsExistentes = $contenido->cuadros()->pluck('id')->toArray();
        $idsRecibidos = [];

        foreach ($titulos as $i => $titulo) {
            $id = intval($ids[$i] ?? 0);
            $idsRecibidos[] = $id;

            $tituloLimpio = trim($titulo ?? '');
            $autorLimpio = trim($autores[$i] ?? '');
            $archivo = $archivos[$i] ?? null;
            $hayArchivo = $archivo && $archivo->isValid();

        
            if (!$id && empty($tituloLimpio) && empty($autorLimpio) && !$hayArchivo) continue;

            
            if ($id > 0) {
                $cuadro = Cuadro::find($id);
                if (!$cuadro) continue;

                $cuadro->titulo = $tituloLimpio;
                $cuadro->autor = $autorLimpio;

                if ($hayArchivo) {
                    if ($cuadro->archivo) Storage::disk('public')->delete($cuadro->archivo);
                    $cuadro->archivo = $archivo->store('cuadros', 'public');
                }

                $cuadro->save();
                continue;
            }

          
            $nuevo = [
                'titulo' => $tituloLimpio,
                'autor' => $autorLimpio,
            ];

            if ($hayArchivo) {
                $nuevo['archivo'] = $archivo->store('cuadros', 'public');
            }

            $contenido->cuadros()->create($nuevo);
        }

    
        $paraBorrar = array_diff($idsExistentes, $idsRecibidos);

        foreach ($paraBorrar as $idBorrar) {
            $cuadro = Cuadro::find($idBorrar);
            if ($cuadro) {
                if ($cuadro->archivo) Storage::disk('public')->delete($cuadro->archivo);
                $cuadro->delete();
            }
        }
    }
}
