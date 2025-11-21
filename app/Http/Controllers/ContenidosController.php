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
    // ---------------------------------------------------------
    // LISTADO
    // ---------------------------------------------------------
    public function listado()
    {
        $contenidos = Contenidos::with(['seccion', 'archivos', 'cuadros'])->get();
        return view('Contenidos.listado', compact('contenidos'));
    }

    // ---------------------------------------------------------
    // FORM CREAR
    // ---------------------------------------------------------
    public function crear()
    {
        $secciones = Seccion::all();
        return view('Contenidos.contenidos', compact('secciones'));
    }

    // ---------------------------------------------------------
    // GUARDAR NUEVO CONTENIDO
    // ---------------------------------------------------------
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
            'cuadro_id.*' => 'nullable|integer'
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

    // ---------------------------------------------------------
    // FORM EDITAR
    // ---------------------------------------------------------
    public function editar($id)
    {
        $contenido = Contenidos::with(['archivos', 'cuadros'])->findOrFail($id);
        $secciones = Seccion::all();
        return view('Contenidos.editar', compact('contenido', 'secciones'));
    }

    // ---------------------------------------------------------
    // ACTUALIZAR CONTENIDO
    // ---------------------------------------------------------
    public function actualizar(Request $request, $id)
    {
        $contenido = Contenidos::with(['archivos', 'cuadros'])->findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'seccion_id' => 'required|exists:secciones,id',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadro_titulo.*' => 'nullable|string|max:255',
            'cuadro_autor.*' => 'nullable|string|max:255',
            'cuadro_archivo.*' => 'nullable|file|max:5120',
            'cuadro_id.*' => 'nullable|integer'
        ]);

        $datos = $request->only(['titulo', 'descripcion', 'seccion_id']);

        if ($request->hasFile('imagen')) {
            if ($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)) {
                Storage::disk('public')->delete($contenido->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('contenidos', 'public');
        }

        $contenido->update($datos);

        $this->guardarArchivos($request, $contenido);
        $this->guardarCuadros($request, $contenido);

        return redirect()->route('contenidos.listado')->with('success', 'Contenido actualizado correctamente.');
    }

    // ---------------------------------------------------------
    // ELIMINAR CONTENIDO
    // ---------------------------------------------------------
    public function borrar($id)
    {
        $contenido = Contenidos::with(['archivos', 'cuadros'])->findOrFail($id);

        // PROTEGER RELACIONES NULL
        $archivos = $contenido->archivos ?? collect();
        $cuadros  = $contenido->cuadros ?? collect();

        // BORRAR ARCHIVOS
        foreach ($archivos as $archivo) {
            if ($archivo->archivo && Storage::disk('public')->exists($archivo->archivo)) {
                Storage::disk('public')->delete($archivo->archivo);
            }
            $archivo->delete();
        }

        // BORRAR CUADROS
        foreach ($cuadros as $cuadro) {
            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }
            $cuadro->delete();
        }

        // BORRAR CONTENIDO
        $contenido->delete();

        return redirect()->route('contenidos.listado')->with('success', 'Contenido eliminado correctamente.');
    }

    // ---------------------------------------------------------
    // MOSTRAR CONTENIDO
    // ---------------------------------------------------------
    public function mostrar($id)
    {
        $contenido = Contenidos::with(['seccion', 'archivos', 'cuadros'])->findOrFail($id);
        return view('Contenidos.mostrar', compact('contenido'));
    }

    // ---------------------------------------------------------
    // FUNCIONES PRIVADAS
    // ---------------------------------------------------------
    private function guardarArchivos(Request $request, $contenido)
    {
        $archivos = $request->file('archivos');

        if (!is_iterable($archivos)) return;

        foreach ($archivos as $archivo) {
            if (!$archivo || !$archivo->isValid()) continue;

            $ruta = $archivo->store('archivos', 'public');

            $contenido->archivos()->create([
                'nombre' => $archivo->getClientOriginalName() ?: 'sin_nombre',
                'ruta' => $ruta,
                'tipo' => $archivo->getClientOriginalExtension() ?: 'desconocido',
                'archivable_id' => $contenido->id,
                'archivable_type' => Contenidos::class,
            ]);
        }
    }

    private function guardarCuadros(Request $request, $contenido)
    {
        $ids = $request->cuadro_id ?? [];
        $titulos = $request->cuadro_titulo ?? [];
        $autores = $request->cuadro_autor ?? [];
        $archivos = $request->file('cuadro_archivo', []);

        $idsExistentes = $contenido->cuadros()->pluck('id')->toArray();
        $idsRecibidos = [];

        foreach ($titulos as $i => $titulo) {
            $id = intval($ids[$i] ?? 0);
            $idsRecibidos[] = $id;

            $tituloLimpio = trim($titulo ?? '');
            $autorLimpio = trim($autores[$i] ?? '');
            $hayArchivo = isset($archivos[$i]) && $archivos[$i] && $archivos[$i]->isValid();

            if ($id === 0 && $tituloLimpio === '' && $autorLimpio === '' && !$hayArchivo) continue;

            if ($id > 0) {
                $cuadro = Cuadro::find($id);
                if (!$cuadro) continue;

                $cuadro->titulo = $tituloLimpio;
                $cuadro->autor = $autorLimpio;

                if ($hayArchivo) {
                    if ($cuadro->archivo) Storage::disk('public')->delete($cuadro->archivo);
                    $cuadro->archivo = $archivos[$i]->store('cuadros', 'public');
                }

                $cuadro->save();
                continue;
            }

            // Crear nuevo
            $nuevo = [
                'titulo' => $tituloLimpio,
                'autor' => $autorLimpio,
            ];

            if ($hayArchivo) {
                $nuevo['archivo'] = $archivos[$i]->store('cuadros', 'public');
            }

            $contenido->cuadros()->create($nuevo);
        }

        // Eliminar cuadros que se quitaron del formulario
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
