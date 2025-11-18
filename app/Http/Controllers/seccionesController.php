<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;

class SeccionesController extends Controller
{
    // Listado de secciones
    public function listado()
    {
        $secciones = Seccion::all();
        return view('secciones.listado', [
            'secciones' => $secciones,
            'seccionActual' => null
        ]);
    }

    // Mostrar sección con contenidos, cuadros y archivos
    public function mostrar($id)
    {
        $secciones = Seccion::all();
        $seccion = Seccion::with(['contenidos', 'cuadros', 'archivos'])->findOrFail($id);

        return view('secciones.mostrar', [
            'secciones' => $secciones,
            'seccion' => $seccion,
            'seccionActual' => $seccion 
        ]);
    }

    // Formulario para crear sección
    public function crear()
    {
        $secciones = Seccion::all();
        return view('secciones.secciones', compact('secciones'));
    }

    // Guardar nueva sección con imagen
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['nombre', 'descripcion']);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('secciones', 'public');
        }

        Seccion::create($data);

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección creada correctamente.');
    }

    // Formulario para editar sección
    public function editar($id)
    {
        $secciones = Seccion::all();
        $seccion = Seccion::findOrFail($id);
        return view('secciones.editar', compact('secciones', 'seccion'));
    }

    // Actualizar sección con imagen
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
        ]);

        $seccion = Seccion::findOrFail($id);

        $data = $request->only(['nombre', 'descripcion']);

        if ($request->hasFile('imagen')) {
            if ($seccion->imagen) {
                Storage::disk('public')->delete($seccion->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('secciones', 'public');
        }

        $seccion->update($data);

        return redirect()->route('secciones.mostrar', $seccion->id)
                         ->with('success', 'Sección actualizada correctamente.');
    }

    // Eliminar sección
    public function borrar($id)
    {
        $seccion = Seccion::findOrFail($id);

        if ($seccion->imagen) {
            Storage::disk('public')->delete($seccion->imagen);
        }

        $seccion->delete();

        return redirect()->route('secciones.listado')
                         ->with('success', 'Sección eliminada correctamente.');
    }

    // Guardar uno o varios cuadros asociados a la sección
    public function guardarCuadro(Request $request, $id)
    {
        $seccion = Seccion::findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'archivo.*' => 'nullable|file|max:10240', // múltiples archivos
        ]);

        $titulo = $request->titulo;
        $autor = $request->autor;

        if ($request->hasFile('archivo')) {
            foreach ($request->file('archivo') as $archivo) {
                $seccion->cuadros()->create([
                    'titulo' => $titulo,
                    'autor' => $autor,
                    'archivo' => $archivo->store('cuadros', 'public'),
                    'nombre_real' => $archivo->getClientOriginalName(),
                ]);
            }
        }

        return back()->with('success', 'Cuadro(s) agregado(s) correctamente.');
    }

    // Eliminar cuadro
    public function eliminarCuadro($cuadroId)
    {
        $cuadro = Cuadro::findOrFail($cuadroId);

        if ($cuadro->archivo) {
            Storage::disk('public')->delete($cuadro->archivo);
        }

        $cuadro->delete();

        return back()->with('success', 'Cuadro eliminado correctamente.');
    }
}
