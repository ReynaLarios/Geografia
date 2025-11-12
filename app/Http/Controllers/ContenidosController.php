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
    /* ==========================================================
       LISTADO
    ========================================================== */
    public function listado()
    {
        $contenidos = Contenidos::with(['seccion','archivos','cuadros'])->get();
        return view('Contenidos.contenidos', compact('contenidos'));
    }

    /* ==========================================================
       CREAR
    ========================================================== */
    public function crear()
    {
        $secciones = Seccion::all();
        return view('Contenidos.crear', compact('secciones'));
    }

    /* ==========================================================
       GUARDAR
    ========================================================== */
    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'seccion_id' => 'required|exists:secciones,id',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadros.*.titulo' => 'nullable|string|max:255',
            'cuadros.*.autor' => 'nullable|string|max:255',
            'cuadros.*.archivo' => 'nullable|file|max:5120'
        ]);

        // Crear contenido
        $datos = $request->only(['titulo','descripcion','seccion_id']);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('contenidos', 'public');
        }

        $contenido = Contenidos::create($datos);

        /* Archivos */
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $file) {
                $contenido->archivos()->create([
                    'nombre' => $file->getClientOriginalName(),
                    'ruta' => $file->store('archivos', 'public'),
                    'tipo' => $file->getClientOriginalExtension()
                ]);
            }
        }

        /* Cuadros */
        if ($request->filled('cuadros')) {
            foreach ($request->cuadros as $item) {
                
                // Si viene info del cuadro
                if ($item['titulo'] || $item['autor'] || isset($item['archivo'])) {

                    $archivoPath = isset($item['archivo'])
                        ? $item['archivo']->store('cuadros', 'public')
                        : null;

                    Cuadro::create([
                        'titulo' => $item['titulo'],
                        'autor' => $item['autor'],
                        'archivo' => $archivoPath,
                        'mostrar' => true,
                        'contenido_id' => $contenido->id
                    ]);
                }
            }
        }

        return redirect()->route('contenidos.listado')
                         ->with('success', 'Contenido creado correctamente.');
    }

    /* ==========================================================
       EDITAR
    ========================================================== */
    public function editar($id)
    {
        $contenido = Contenidos::with(['archivos','cuadros'])->findOrFail($id);
        $secciones = Seccion::all();

        return view('Contenidos.editar', compact('contenido','secciones'));
    }

    /* ==========================================================
       ACTUALIZAR
    ========================================================== */
    public function actualizar(Request $request, $id)
    {
        $contenido = Contenidos::with(['cuadros'])->findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'seccion_id' => 'required|exists:secciones,id',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:2048',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadros.*.titulo' => 'nullable|string|max:255',
            'cuadros.*.autor' => 'nullable|string|max:255',
            'cuadros.*.archivo' => 'nullable|file|max:5120'
        ]);

        $datos = $request->only(['titulo','descripcion','seccion_id']);

        /* Imagen */
        if ($request->hasFile('imagen')) {

            if ($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)) {
                Storage::disk('public')->delete($contenido->imagen);
            }

            $datos['imagen'] = $request->file('imagen')->store('contenidos','public');
        }

        $contenido->update($datos);

        /* Archivos nuevos */
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $file) {
                $contenido->archivos()->create([
                    'nombre' => $file->getClientOriginalName(),
                    'ruta' => $file->store('archivos','public'),
                    'tipo' => $file->getClientOriginalExtension()
                ]);
            }
        }

        /* Cuadros nuevos */
        if ($request->filled('cuadros')) {
            foreach ($request->cuadros as $item) {

                if ($item['titulo'] || $item['autor'] || isset($item['archivo'])) {

                    $archivoPath = isset($item['archivo'])
                        ? $item['archivo']->store('cuadros','public')
                        : null;

                    Cuadro::create([
                        'titulo' => $item['titulo'],
                        'autor' => $item['autor'],
                        'archivo' => $archivoPath,
                        'mostrar' => true,
                        'contenido_id' => $contenido->id
                    ]);
                }
            }
        }

        return redirect()->route('contenidos.listado')
                         ->with('success','Contenido actualizado correctamente.');
    }

    /* ==========================================================
       MOSTRAR
    ========================================================== */
    public function mostrar($id)
    {
        $contenido = Contenidos::with(['seccion','archivos','cuadros'])->findOrFail($id);
        $secciones = Seccion::all();

        return view('contenidos.mostrar', compact('contenido','secciones'));
    }

    /* ==========================================================
       BORRAR
    ========================================================== */
    public function borrar($id)
    {
        $contenido = Contenidos::findOrFail($id);

        // Archivos
        foreach ($contenido->archivos as $archivo) {
            Storage::disk('public')->delete($archivo->ruta);
            $archivo->delete();
        }

        // Cuadros
        foreach ($contenido->cuadros as $cuadro) {
            if ($cuadro->archivo) {
                Storage::disk('public')->delete($cuadro->archivo);
            }
            $cuadro->delete();
        }

        // Contenido
        $contenido->delete();

        return back()->with('success', 'Contenido eliminado correctamente.');
    }
}
