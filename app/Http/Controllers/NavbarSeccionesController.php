<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NavbarSeccion;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;

class NavbarSeccionesController extends Controller
{

    public function index()
    {
        $secciones = NavbarSeccion::all();
        return view('navbar.secciones.index', [
            'secciones' => $secciones,
            'seccionActual' => null
        ]);
    }


    public function mostrar($id)
    {
        $secciones = NavbarSeccion::all();
        $seccion = NavbarSeccion::with(['contenidosNavbar', 'cuadros', 'archivos'])->findOrFail($id);

        return view('navbar.secciones.mostrar', [
            'secciones' => $secciones,
            'seccion' => $seccion,
            'seccionActual' => $seccion 
        ]);
    }


    public function crear()
    {
        $secciones = NavbarSeccion::all();
        return view('navbar.secciones.crear', compact('secciones'));
    }

   
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
        ]);

        $data = $request->only(['nombre', 'descripcion']);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('navbar_secciones', 'public');
        }

        NavbarSeccion::create($data);

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección creada correctamente.');
    }

    // Formulario para editar sección
    public function editar($id)
    {
        $secciones = NavbarSeccion::all();
        $seccion = NavbarSeccion::findOrFail($id);
        return view('navbar.secciones.editar', compact('secciones', 'seccion'));
    }

    // Actualizar sección con imagen
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
        ]);

        $seccion = NavbarSeccion::findOrFail($id);

        $data = $request->only(['nombre', 'descripcion']);

        if ($request->hasFile('imagen')) {
            if ($seccion->imagen) {
                Storage::disk('public')->delete($seccion->imagen);
            }
            $data['imagen'] = $request->file('imagen')->store('navbar_secciones', 'public');
        }

        $seccion->update($data);

        return redirect()->route('navbar.secciones.mostrar', $seccion->id)
                         ->with('success', 'Sección actualizada correctamente.');
    }

    // Eliminar sección
    public function borrar($id)
    {
        $seccion = NavbarSeccion::findOrFail($id);

        if ($seccion->imagen) {
            Storage::disk('public')->delete($seccion->imagen);
        }

        $seccion->delete();

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección eliminada correctamente.');
    }

    // Guardar uno o varios cuadros asociados a la sección
    public function guardarCuadro(Request $request, $id)
    {
        $seccion = NavbarSeccion::findOrFail($id);

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
