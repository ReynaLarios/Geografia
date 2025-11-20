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
    // LISTADO
    public function index()
    {
        $contenidos = NavbarContenido::with('seccion')->get();
        return view('navbar.contenidos.index', compact('contenidos'));
    }

    // FORMULARIO CREAR
    public function crear(Request $request)
    {
        $secciones = NavbarSeccion::all();

        return view('navbar.contenidos.crear', [
            'secciones' => $secciones,
            'seccionId' => $request->seccion_id ?? null
        ]);
    }

    // GUARDAR
    public function guardar(Request $request)
    {
        $request->validate([
            'navbar_seccion_id' => 'required|exists:navbar_secciones,id',
            'titulo' => 'required|string|max:255'
        ]);

        // Guardar imagen principal
        $rutaImagen = null;
        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('navbar_contenidos', 'public');
        }

        // Crear contenido
        $contenido = NavbarContenido::create([
            'navbar_seccion_id' => $request->navbar_seccion_id,
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $rutaImagen
        ]);

        // Guardar archivos adicionales
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $ruta = $archivo->store('archivos_navbar', 'public');

                Archivo::create([
                    'nombre' => $archivo->getClientOriginalName(),
                    'ruta' => $ruta,
                    'archivable_id' => $contenido->id,
                    'archivable_type' => NavbarContenido::class
                ]);
            }
        }

        // Guardar cuadros
        if ($request->has('cuadros')) {
            foreach ($request->cuadros as $cuadroData) {

                if (
                    empty($cuadroData['titulo']) &&
                    empty($cuadroData['autor']) &&
                    empty($cuadroData['archivo'])
                ) continue;

                $rutaArchivoCuadro = null;

                if (isset($cuadroData['archivo']) && $cuadroData['archivo']) {
                    $rutaArchivoCuadro = $cuadroData['archivo']->store('cuadros', 'public');
                }

                Cuadro::create([
                    'titulo' => $cuadroData['titulo'] ?? null,
                    'autor' => $cuadroData['autor'] ?? null,
                    'archivo' => $rutaArchivoCuadro,
                    'mostrar' => 1,
                    'cuadrobable_id' => $contenido->id,
                    'cuadrobable_type' => NavbarContenido::class,
                ]);
            }
        }

        return redirect()->route('navbar.contenidos.index')
            ->with('success', 'Contenido creado correctamente.');
    }

    // FORMULARIO EDITAR
    public function editar($id)
    {
        $contenido = NavbarContenido::with(['seccion', 'archivos', 'cuadros'])->findOrFail($id);

        // ⚠ Solo traer secciones del navbar
        $secciones = NavbarSeccion::all();

        return view('navbar.contenidos.editar', compact('contenido', 'secciones'));
    }

    // ACTUALIZAR
    public function actualizar(Request $request, $id)
    {
        $contenido = NavbarContenido::findOrFail($id);

        $request->validate([
            'navbar_seccion_id' => 'required|exists:navbar_secciones,id',
            'titulo' => 'required|string|max:255'
        ]);

        // Actualizar imagen principal si se sube nueva
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

        // Aquí podrías actualizar archivos y cuadros si quieres
        // (igual que en guardar, borrando los antiguos o agregando nuevos)

        return redirect()->route('navbar.contenidos.index')
            ->with('success', 'Contenido actualizado correctamente.');
    }

    // BORRAR
    public function borrar($id)
    {
        $contenido = NavbarContenido::with(['archivos', 'cuadros'])->findOrFail($id);

        // Borrar imagen principal
        if ($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)) {
            Storage::disk('public')->delete($contenido->imagen);
        }

        // Borrar archivos adicionales
        foreach ($contenido->archivos as $archivo) {
            if (Storage::disk('public')->exists($archivo->ruta)) {
                Storage::disk('public')->delete($archivo->ruta);
            }
            $archivo->delete();
        }

        // Borrar cuadros
        foreach ($contenido->cuadros as $cuadro) {
            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }
            $cuadro->delete();
        }

        $contenido->delete();

        return redirect()->route('navbar.contenidos.index')
            ->with('success', 'Contenido eliminado correctamente.');
    }
}

