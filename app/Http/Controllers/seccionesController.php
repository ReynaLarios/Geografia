<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Cuadro;
use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;

class SeccionesController extends Controller
{
    // ---------------------------------------------------------
    // LISTADO
    // ---------------------------------------------------------
    public function listado()
    {
        $secciones = Seccion::all();
        return view('secciones.listado', compact('secciones'));
    }

    // ---------------------------------------------------------
    // FORM CREAR
    // ---------------------------------------------------------
    public function crear()
    {
        return view('secciones.secciones'); // vista de crear
    }

    // ---------------------------------------------------------
    // GUARDAR NUEVA SECCIÓN
    // ---------------------------------------------------------
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image',
            'video' => 'nullable|file',
        ]);

        $seccion = Seccion::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen' => $request->hasFile('imagen') ? $request->imagen->store('secciones', 'public') : null,
            'video' => $request->hasFile('video') ? $request->video->store('videos', 'public') : null,
        ]);

        $this->guardarArchivos($request, $seccion);
        $this->guardarCuadros($request, $seccion);

        return redirect()->route('secciones.listado')->with('success', 'Sección creada correctamente');
    }

    // ---------------------------------------------------------
    // MOSTRAR
    // ---------------------------------------------------------
    public function mostrar($id)
    {
        $seccion = Seccion::with(['archivos', 'cuadros.archivos'])->findOrFail($id);

        if ($id == 13) {
            return redirect()->route('videoteca.index');
        }

        return view('secciones.mostrar', compact('seccion'));
    }

    // ---------------------------------------------------------
    // FORM EDITAR
    // ---------------------------------------------------------
    public function editar($id)
    {
        $seccion = Seccion::with(['archivos', 'cuadros.archivos'])->findOrFail($id);
        return view('secciones.editar', compact('seccion'));
    }

    // ---------------------------------------------------------
    // ACTUALIZAR
    // ---------------------------------------------------------
    public function actualizar(Request $request, $id)
{
    $seccion = Seccion::with(['archivos', 'cuadros.archivos'])->findOrFail($id);

    // Actualizar datos básicos
    $seccion->update([
        'nombre' => $request->nombre,
        'descripcion' => $request->descripcion,
    ]);

    // ---------------------------
    // Imagen y video principal
    // ---------------------------
    if ($request->eliminar_imagen && $seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
        Storage::disk('public')->delete($seccion->imagen);
        $seccion->imagen = null;
    }
    if ($request->hasFile('imagen')) {
        if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
            Storage::disk('public')->delete($seccion->imagen);
        }
        $seccion->imagen = $request->imagen->store('secciones', 'public');
    }

    if ($request->eliminar_video && $seccion->video && Storage::disk('public')->exists($seccion->video)) {
        Storage::disk('public')->delete($seccion->video);
        $seccion->video = null;
    }
    if ($request->hasFile('video')) {
        if ($seccion->video && Storage::disk('public')->exists($seccion->video)) {
            Storage::disk('public')->delete($seccion->video);
        }
        $seccion->video = $request->video->store('videos', 'public');
    }

    $seccion->save();

    // ---------------------------
    // Archivos eliminados
    // ---------------------------
    if ($request->archivos_eliminados) {
        // Convierte a array seguro
        $ids = is_array($request->archivos_eliminados)
            ? $request->archivos_eliminados
            : json_decode($request->archivos_eliminados, true);

        if (is_array($ids)) {
            foreach ($id as $archivoId) {
                $archivo = Archivo::find($archivoId);
                if ($archivo && $archivo->ruta && Storage::disk('storage')->exists($archivo->ruta)) {
                    Storage::disk('storage')->delete($archivo->ruta);
                    $archivo->delete();
                }
            }
        }
    }

    // ---------------------------
    // Guardar nuevos archivos
    // ---------------------------
    $this->guardarArchivos($request, $seccion);

    // ---------------------------
    // Guardar cuadros y sus archivos
    // ---------------------------
    $this->guardarCuadros($request, $seccion);

    return redirect()->route('secciones.listado')->with('success', 'Sección actualizada correctamente');
}

    // ---------------------------------------------------------
    // ELIMINAR SECCIÓN
    // ---------------------------------------------------------
    public function borrar($id)
    {
        $seccion = Seccion::with(['archivos', 'cuadros.archivos'])->findOrFail($id);

        $this->eliminarArchivoFisico($seccion->imagen);
        $this->eliminarArchivoFisico($seccion->video);

        // Archivos de la sección
        foreach ($seccion->archivos as $archivo) {
            $this->eliminarArchivoFisico($archivo->ruta);
            $archivo->delete();
        }

        // Cuadros y sus archivos
        foreach ($seccion->cuadros as $cuadro) {
            foreach ($cuadro->archivos as $archivo) {
                $this->eliminarArchivoFisico($archivo->ruta);
                $archivo->delete();
            }
            $cuadro->delete();
        }

        $seccion->delete();

        return redirect()->route('secciones.listado')->with('success', 'Sección eliminada correctamente');
    }

    // ---------------------------------------------------------
    // FUNCIONES COMPARTIDAS
    // ---------------------------------------------------------
    private function guardarArchivos(Request $request, $seccion)
    {
        $archivos = $request->file('archivos');
        if (!$archivos || !is_array($archivos)) return;

        foreach ($archivos as $archivo) {
            if (!$archivo || !$archivo->isValid()) continue;

            $ruta = $archivo->store('archivos', 'public');

            $seccion->archivos()->create([
                'nombre' => $archivo->getClientOriginalName() ?: 'sin_nombre',
                'ruta' => $ruta,
                'tipo' => $archivo->getClientOriginalExtension() ?: 'desconocido',
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
            $autorLimpio = trim($autores[$i] ?? '');
            $archivo = $archivos[$i] ?? null;
            $hayArchivo = $archivo && $archivo->isValid();

            if (empty($tituloLimpio) && empty($autorLimpio) && !$hayArchivo) continue;

            if ($id > 0) {
                $cuadro = Cuadro::find($id);
                if (!$cuadro) continue;

                $cuadro->update([
                    'titulo' => $tituloLimpio,
                    'autor' => $autorLimpio,
                ]);

                if ($hayArchivo) {
                    $cuadro->archivos()->create([
                        'nombre' => $archivo->getClientOriginalName(),
                        'ruta' => $archivo->store('cuadros', 'public'),
                        'tipo' => $archivo->getClientOriginalExtension(),
                    ]);
                }

                continue;
            }
            $titulo = $request->titulo;
            $autor = $request->autor; 
            // Nuevo cuadro
            $cuadro = $seccion->cuadros()->create([
                'titulo' => $titulo,
                'autor' => $autor,
            ]);

            if ($archivo) {
                $cuadro->archivos()->create([
                    'nombre' => $archivo->getClientOriginalName(),
                    'ruta' => $archivo->store('cuadros', 'public'),
                    'tipo' => $archivo->getClientOriginalExtension(),
                ]);
            }
        }

        // Borrar cuadros eliminados
        $paraBorrar = array_diff($idsExistentes, $idsRecibidos);
        foreach ($paraBorrar as $idBorrar) {
            $cuadro = Cuadro::find($idBorrar);
            if ($cuadro) {
                foreach ($cuadro->archivos as $archivo) {
                    $this->eliminarArchivoFisico($archivo->ruta);
                    $archivo->delete();
                }
                $cuadro->delete();
            }
        }
    }

    // ---------------------------------------------------------
    // ELIMINA UN ARCHIVO FÍSICO SI EXISTE
    // ---------------------------------------------------------
    private function eliminarArchivoFisico($ruta)
    {
        if ($ruta && Storage::disk('public')->exists($ruta)) {
            Storage::disk('public')->delete($ruta);
        }
    }
}
