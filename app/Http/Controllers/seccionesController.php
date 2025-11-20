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
        return view('secciones.secciones');
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

        $seccion = new Seccion();
        $seccion->nombre = $request->nombre;
        $seccion->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            $seccion->imagen = $request->imagen->store('secciones', 'public');
        }

        if ($request->hasFile('video')) {
            $seccion->video = $request->video->store('videos', 'public');
        }

        $seccion->save();

        $this->guardarArchivos($request, $seccion);
        $this->guardarCuadros($request, $seccion);

        return redirect()->route('secciones.listado')->with('success', 'Sección creada correctamente');
    }

    // ---------------------------------------------------------
    // MOSTRAR
    // ---------------------------------------------------------
    public function mostrar($id)
    {
        if ($id == 13) { 
            return redirect()->route('videoteca.index');
        }

        $seccion = Seccion::with(['archivos', 'cuadros', 'contenidos'])->findOrFail($id);
        return view('secciones.mostrar', compact('seccion'));
    }

    // ---------------------------------------------------------
    // FORM EDITAR
    // ---------------------------------------------------------
    public function editar($id)
    {
        $seccion = Seccion::with(['archivos', 'cuadros'])->findOrFail($id);
        return view('secciones.editar', compact('seccion'));
    }

    // ---------------------------------------------------------
    // ACTUALIZAR
    // ---------------------------------------------------------
    public function actualizar(Request $request, $id)
    {
        $seccion = Seccion::findOrFail($id);

        $seccion->nombre = $request->nombre;
        $seccion->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
                Storage::disk('public')->delete($seccion->imagen);
            }
            $seccion->imagen = $request->imagen->store('secciones', 'public');
        }

        if ($request->hasFile('video')) {
            if ($seccion->video && Storage::disk('public')->exists($seccion->video)) {
                Storage::disk('public')->delete($seccion->video);
            }
            $seccion->video = $request->video->store('videos', 'public');
        }

        $seccion->save();

        $this->guardarArchivos($request, $seccion);
        $this->guardarCuadros($request, $seccion);

        return redirect()->route('secciones.listado')->with('success', 'Sección actualizada correctamente');
    }

    // ---------------------------------------------------------
    // ELIMINAR / BORRAR
    // ---------------------------------------------------------
    public function borrar($id)
    {
        $seccion = Seccion::with(['archivos', 'cuadros'])->find($id);

        if (!$seccion) {
            return redirect()->back()->with('error', 'Sección no encontrada');
        }

        // Borrar imagen y video de la sección
        if ($seccion->imagen) Storage::disk('public')->delete($seccion->imagen);
        if ($seccion->video) Storage::disk('public')->delete($seccion->video);

        // Borrar archivos relacionados
        foreach ($seccion->archivos as $archivo) {
            if ($archivo->ruta) Storage::disk('public')->delete($archivo->ruta);
            $archivo->delete();
        }

        // Borrar cuadros relacionados
        foreach ($seccion->cuadros as $cuadro) {
            if ($cuadro->ruta) Storage::disk('public')->delete($cuadro->ruta);
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
                'archivable_id' => $seccion->id,
                'archivable_type' => Seccion::class,
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

                $cuadro->titulo = $tituloLimpio;
                $cuadro->autor = $autorLimpio;

                if ($hayArchivo) {
                    if ($cuadro->ruta) Storage::disk('public')->delete($cuadro->ruta);

                    $cuadro->ruta = $archivo->store('cuadros', 'public');
                    $cuadro->nombre = $archivo->getClientOriginalName();
                    $cuadro->tipo = $archivo->getClientOriginalExtension();
                }

                $cuadro->save();
                continue;
            }

            $nuevo = [
                'titulo' => $tituloLimpio,
                'autor' => $autorLimpio,
                'ruta' => $hayArchivo ? $archivo->store('cuadros', 'public') : null,
                'nombre' => $hayArchivo ? $archivo->getClientOriginalName() : null,
                'tipo' => $hayArchivo ? $archivo->getClientOriginalExtension() : null,
            ];

            $seccion->cuadros()->create($nuevo);
        }

        $paraBorrar = array_diff($idsExistentes, $idsRecibidos);
        foreach ($paraBorrar as $idBorrar) {
            $cuadro = Cuadro::find($idBorrar);
            if ($cuadro) {
                if ($cuadro->ruta) Storage::disk('public')->delete($cuadro->ruta);
                $cuadro->delete();
            }
        }
    }
}
