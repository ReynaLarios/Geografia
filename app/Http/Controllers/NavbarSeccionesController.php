<?php

namespace App\Http\Controllers;

use App\Models\NavbarSeccion;
use App\Models\Cuadro;
use Illuminate\Http\Request;

class NavbarSeccionesController extends Controller
{
    // 📋 Mostrar todas las secciones del navbar
    public function index()
    {
        $secciones = NavbarSeccion::all();
        return view('navbar.secciones.index', compact('secciones'));
    }

    // ➕ Formulario para crear nueva sección
    public function crear()
    {
        return view('navbar.secciones.crear');
    }

    // 💾 Guardar nueva sección
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Guardar imagen principal
        $imagen = null;
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        // Archivos múltiples
        $archivosGuardados = [];
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $file) {
                $archivosGuardados[] = $file->store('archivos', 'public');
            }
        }

        // Crear la sección
        $seccion = NavbarSeccion::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'imagen' => $imagen,
            'archivos' => $archivosGuardados
        ]);

        // Guardar cuadros si existen
        if ($request->cuadros) {
            foreach ($request->cuadros as $cuadro) {
                $archivoCuadro = null;
                if (isset($cuadro['archivo'])) {
                    $archivoCuadro = $cuadro['archivo']->store('cuadros', 'public');
                }

                Cuadro::create([
                    'cuadrobable_id' => $seccion->id,
                    'cuadrobable_type' => NavbarSeccion::class,
                    'titulo' => $cuadro['titulo'] ?? '',
                    'autor' => $cuadro['autor'] ?? '',
                    'archivo' => $archivoCuadro,
                    'mostrar' => isset($cuadro['mostrar']) ? 1 : 0
                ]);
            }
        }

        return redirect()->route('navbar.secciones.index')->with('ok', 'Sección guardada correctamente.');
    }

    // 👁️ Mostrar una sección específica
    public function mostrar($id)
    {
        $seccion = NavbarSeccion::with('cuadros')->findOrFail($id);
        return view('navbar.secciones.mostrar', compact('seccion'));
    }

    // ✏️ Editar sección existente
    public function editar($id)
    {
        $seccion = NavbarSeccion::with('cuadros')->findOrFail($id);
        return view('navbar.secciones.editar', compact('seccion'));
    }

    // 🗑️ Borrar sección
    public function borrar($id)
    {
        Cuadro::where('cuadrobable_id', $id)
            ->where('cuadrobable_type', NavbarSeccion::class)
            ->delete();

        NavbarSeccion::where('id', $id)->delete();

        return back()->with('ok', 'Sección eliminada correctamente.');
    }

    // ⚙️ Panel de administración
    public function panel()
    {
        $navbarSecciones = NavbarSeccion::all();
        return view('navbar.secciones.panel', compact('navbarSecciones'));
    }

    // 🔄 Actualizar sección
    public function actualizar(Request $request, $id)
    {
        $seccion = NavbarSeccion::findOrFail($id);

        $validated = $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        // Si se sube una nueva imagen, reemplazar la anterior
        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('navbar_secciones', 'public');
            $validated['imagen'] = $path;
        }

        // Actualizar los datos
        $seccion->update($validated);

        return redirect()
            ->route('navbar.secciones.mostrar', $seccion->id)
            ->with('ok', 'Sección actualizada correctamente.');
    }
}

