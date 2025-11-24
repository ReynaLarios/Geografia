<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NavbarSeccion;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;

class NavbarSeccionesController extends Controller
{
    // LISTADO
    public function index()
    {
        $secciones = NavbarSeccion::with(['cuadros.archivos', 'archivos'])->get();
        return view('navbar.secciones.index', compact('secciones'));
    }

    // FORMULARIO CREAR
    public function crear()
    {
        return view('navbar.secciones.crear');
    }

    // GUARDAR
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadros' => 'nullable|array',
        ]);

        // Imagen principal de la sección
        $rutaImagen = $request->hasFile('imagen') ? $request->file('imagen')->store('navbar_secciones', 'public') : null;

        $seccion = NavbarSeccion::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen' => $rutaImagen
        ]);

        // Archivos adicionales de la sección
        foreach ($request->file('archivos') ?? [] as $archivo) {
            $seccion->archivos()->create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta' => $archivo->store('archivos_seccion', 'public'),
                'tipo' => $archivo->getClientOriginalExtension()
            ]);
        }

        // Cuadros de la sección
        foreach ($request->cuadros ?? [] as $cuadroData) {
            if (empty($cuadroData['titulo']) && empty($cuadroData['autor']) && empty($cuadroData['archivo'])) continue;

            // Archivo principal del cuadro
            $archivoPrincipal = isset($cuadroData['archivo']) ? $cuadroData['archivo']->store('cuadros', 'public') : null;

            $cuadro = $seccion->cuadros()->create([
                'titulo' => $cuadroData['titulo'] ?? null,
                'autor' => $cuadroData['autor'] ?? null,
                'archivo' => $archivoPrincipal
            ]);

            // Archivos adicionales del cuadro
            foreach ($cuadroData['archivos'] ?? [] as $archivoExtra) {
                $cuadro->archivos()->create([
                    'nombre' => $archivoExtra->getClientOriginalName(),
                    'ruta' => $archivoExtra->store('archivos/cuadros', 'public'),
                    'tipo' => $archivoExtra->getClientOriginalExtension()
                ]);
            }
        }

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección creada correctamente.');
    }

    // FORMULARIO EDITAR
    public function editar($id)
    {
        $seccion = NavbarSeccion::with(['cuadros.archivos', 'archivos'])->findOrFail($id);
        return view('navbar.secciones.editar', compact('seccion'));
    }

    // ACTUALIZAR
    public function actualizar(Request $request, $id)
    {
        $seccion = NavbarSeccion::with(['cuadros.archivos', 'archivos'])->findOrFail($id);

        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadros' => 'nullable|array',
        ]);

        // Imagen principal
        if ($request->hasFile('imagen')) {
            if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
                Storage::disk('public')->delete($seccion->imagen);
            }
            $seccion->imagen = $request->file('imagen')->store('navbar_secciones', 'public');
        }

        $seccion->nombre = $request->nombre;
        $seccion->descripcion = $request->descripcion;
        $seccion->save();

        // Archivos adicionales de la sección
        foreach ($request->file('archivos') ?? [] as $archivo) {
            $seccion->archivos()->create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta' => $archivo->store('archivos_seccion', 'public'),
                'tipo' => $archivo->getClientOriginalExtension()
            ]);
        }

        // Manejo de cuadros
        $idsRecibidos = collect($request->cuadros ?? [])->pluck('id')->filter()->all();
        $idsExistentes = $seccion->cuadros->pluck('id')->all();

        // Borrar cuadros eliminados
        foreach (array_diff($idsExistentes, $idsRecibidos) as $idBorrar) {
            $cuadro = Cuadro::find($idBorrar);
            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }
            foreach ($cuadro->archivos ?? [] as $archivo) {
                if (Storage::disk('public')->exists($archivo->ruta)) {
                    Storage::disk('public')->delete($archivo->ruta);
                }
                $archivo->delete();
            }
            $cuadro->delete();
        }

        // Crear o actualizar cuadros
        foreach ($request->cuadros ?? [] as $cuadroData) {
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
                $archivoPrincipal = isset($cuadroData['archivo']) ? $cuadroData['archivo']->store('cuadros', 'public') : null;

                $cuadro = $seccion->cuadros()->create([
                    'titulo' => $cuadroData['titulo'] ?? null,
                    'autor' => $cuadroData['autor'] ?? null,
                    'archivo' => $archivoPrincipal
                ]);
            }

            foreach ($cuadroData['archivos'] ?? [] as $archivoExtra) {
                $cuadro->archivos()->create([
                    'nombre' => $archivoExtra->getClientOriginalName(),
                    'ruta' => $archivoExtra->store('archivos/cuadros', 'public'),
                    'tipo' => $archivoExtra->getClientOriginalExtension()
                ]);
            }
        }

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección actualizada correctamente.');
    }

    // BORRAR
    public function borrar($id)
    {
        $seccion = NavbarSeccion::with(['cuadros.archivos', 'archivos'])->findOrFail($id);

        if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
            Storage::disk('public')->delete($seccion->imagen);
        }

        foreach ($seccion->archivos ?? [] as $archivo) {
            if (Storage::disk('public')->exists($archivo->ruta)) {
                Storage::disk('public')->delete($archivo->ruta);
            }
            $archivo->delete();
        }

        foreach ($seccion->cuadros ?? [] as $cuadro) {
            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }
            foreach ($cuadro->archivos ?? [] as $archivo) {
                if (Storage::disk('public')->exists($archivo->ruta)) {
                    Storage::disk('public')->delete($archivo->ruta);
                }
                $archivo->delete();
            }
            $cuadro->delete();
        }

        $seccion->delete();

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección eliminada correctamente.');
    }

    // MOSTRAR
    public function mostrar($id)
    {
        $seccion = NavbarSeccion::with(['cuadros.archivos', 'archivos'])->findOrFail($id);
        return view('navbar.secciones.mostrar', compact('seccion'));
    }
}
