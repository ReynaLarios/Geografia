<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;

class SeccionesController extends Controller
{
    /**
     * Listado de todas las secciones
     */
    public function listado()
    {
        $secciones = Seccion::all();
        return view('secciones.listado', compact('secciones'))->with('seccionActual', null);
    }

    /**
     * Mostrar una sección con sus contenidos, cuadros y archivos
     */
    public function mostrar($id)
    {
        $seccion = Seccion::with(['contenidos', 'cuadros', 'archivos'])->findOrFail($id);
        $secciones = Seccion::all();

        return view('secciones.mostrar', compact('secciones', 'seccion'))->with('seccionActual', $seccion);
    }

    /**
     * Formulario para crear una sección
     */
    public function crear()
    {
        $secciones = Seccion::all();
        return view('secciones.secciones', compact('secciones'));
    }

    /**
     * Guardar nueva sección junto con cuadros dinámicos
     */
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:51200',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadro_archivo.*' => 'nullable|file|max:10240'
        ]);

        // Crear sección
        $data = $request->only(['nombre', 'descripcion']);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('secciones', 'public');
        }

        if ($request->hasFile('video')) {
            $data['video'] = $request->file('video')->store('secciones/videos', 'public');
        }

        $seccion = Seccion::create($data);

        // Guardar archivos adicionales
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $seccion->archivos()->create([
                    'archivo' => $archivo->store('secciones/archivos', 'public'),
                    'nombre_real' => $archivo->getClientOriginalName(),
                ]);
            }
        }

        // Guardar cuadros dinámicos
        $titulos = $request->input('cuadro_titulo', []);
        $autores = $request->input('cuadro_autor', []);
        $mostrar = $request->input('mostrar_cuadro', []);
        $archivosCuadro = $request->file('cuadro_archivo', []);

        foreach($titulos as $index => $titulo) {
            $cuadro = new Cuadro();
            $cuadro->seccion_id = $seccion->id;
            $cuadro->titulo = $titulo;
            $cuadro->autor = $autores[$index] ?? '';
            $cuadro->mostrar = isset($mostrar[$index]) ? 1 : 0;

            if(isset($archivosCuadro[$index]) && $archivosCuadro[$index]->isValid()) {
                $cuadro->archivo = $archivosCuadro[$index]->store('cuadros', 'public');
                $cuadro->nombre_real = $archivosCuadro[$index]->getClientOriginalName();
            }

            $cuadro->save();
        }

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección creada correctamente.');
    }

    /**
     * Formulario para editar sección
     */
    public function editar($id)
    {
        $secciones = Seccion::all();
        $seccion = Seccion::with(['cuadros', 'archivos'])->findOrFail($id);
        return view('secciones.editar', compact('secciones', 'seccion'));
    }

    /**
     * Actualizar sección existente junto con cuadros
     */
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
            'video' => 'nullable|mimetypes:video/mp4,video/webm,video/ogg|max:51200',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadro_archivo.*' => 'nullable|file|max:10240'
        ]);

        $seccion = Seccion::findOrFail($id);

        $data = $request->only(['nombre', 'descripcion']);

        // Reemplazar imagen si suben nueva
        if ($request->hasFile('imagen')) {
            if ($seccion->imagen) Storage::disk('public')->delete($seccion->imagen);
            $data['imagen'] = $request->file('imagen')->store('secciones', 'public');
        }

        // Reemplazar video si suben nuevo
        if ($request->hasFile('video')) {
            if ($seccion->video) Storage::disk('public')->delete($seccion->video);
            $data['video'] = $request->file('video')->store('secciones/videos', 'public');
        }

        $seccion->update($data);

        // Archivos adicionales
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $seccion->archivos()->create([
                    'archivo' => $archivo->store('secciones/archivos', 'public'),
                    'nombre_real' => $archivo->getClientOriginalName(),
                ]);
            }
        }

        // Cuadros
        $titulos = $request->input('cuadro_titulo', []);
        $autores = $request->input('cuadro_autor', []);
        $mostrar = $request->input('mostrar_cuadro', []);
        $archivosCuadro = $request->file('cuadro_archivo', []);

        foreach($titulos as $index => $titulo) {
            $cuadro = new Cuadro();
            $cuadro->seccion_id = $seccion->id;
            $cuadro->titulo = $titulo;
            $cuadro->autor = $autores[$index] ?? '';
            $cuadro->mostrar = isset($mostrar[$index]) ? 1 : 0;

            if(isset($archivosCuadro[$index]) && $archivosCuadro[$index]->isValid()) {
                $cuadro->archivo = $archivosCuadro[$index]->store('cuadros', 'public');
                $cuadro->nombre_real = $archivosCuadro[$index]->getClientOriginalName();
            }

            $cuadro->save();
        }

        return redirect()->route('secciones.mostrar', $seccion->id)
                         ->with('success', 'Sección actualizada correctamente.');
    }

    /**
     * Eliminar sección completa (con imagen, video, archivos y cuadros)
     */
    public function borrar($id)
    {
        $seccion = Seccion::with(['cuadros', 'archivos'])->findOrFail($id);

        // Borrar imagen y video
        if ($seccion->imagen) Storage::disk('public')->delete($seccion->imagen);
        if ($seccion->video) Storage::disk('public')->delete($seccion->video);

        // Borrar archivos adicionales
        foreach ($seccion->archivos as $archivo) {
            Storage::disk('public')->delete($archivo->archivo);
            $archivo->delete();
        }

        // Borrar cuadros
        foreach ($seccion->cuadros as $cuadro) {
            if ($cuadro->archivo) Storage::disk('public')->delete($cuadro->archivo);
            $cuadro->delete();
        }

        $seccion->delete();

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección eliminada correctamente.');
    }

    /**
     * Eliminar un cuadro individual
     */
    public function eliminarCuadro($cuadroId)
    {
        $cuadro = Cuadro::findOrFail($cuadroId);
        if ($cuadro->archivo) Storage::disk('public')->delete($cuadro->archivo);
        $cuadro->delete();

        return back()->with('success', 'Cuadro eliminado correctamente.');
    }
}
