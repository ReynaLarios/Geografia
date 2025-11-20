<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NavbarSeccion;
use App\Models\Cuadro;
use App\Models\Archivo;
use Illuminate\Support\Facades\Storage;

class NavbarSeccionesController extends Controller
{
    // ---------------------------------------------------------
    // LISTADO
    // ---------------------------------------------------------
    public function index()
    {
        $secciones = NavbarSeccion::all();

        return view('navbar.secciones.index', [
            'secciones' => $secciones,
            'seccionActual' => null
        ]);
    }

    // ---------------------------------------------------------
    // MOSTRAR SECCIÓN
    // ---------------------------------------------------------
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

    // ---------------------------------------------------------
    // FORM CREAR
    // ---------------------------------------------------------
    public function crear()
    {
        $secciones = NavbarSeccion::all();
        return view('navbar.secciones.crear', compact('secciones'));
    }

    // ---------------------------------------------------------
    // GUARDAR
    // ---------------------------------------------------------
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
            'archivos.*' => 'nullable|file|max:10240',

            'cuadros.*.titulo' => 'nullable|string|max:255',
            'cuadros.*.autor' => 'nullable|string|max:255',
            'cuadros.*.archivo' => 'nullable|file|max:10240'
        ]);

        $data = $request->only(['nombre', 'descripcion']);

        if ($request->hasFile('imagen')) {
            $data['imagen'] = $request->file('imagen')->store('navbar_secciones', 'public');
        }

        $seccion = NavbarSeccion::create($data);

        $this->guardarArchivos($request, $seccion);
        $this->guardarCuadrosArray($request, $seccion);

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección creada correctamente.');
    }

    // ---------------------------------------------------------
    // FORM EDITAR
    // ---------------------------------------------------------
    public function editar($id)
    {
        $secciones = NavbarSeccion::all();
        $seccion = NavbarSeccion::with(['cuadros', 'archivos'])->findOrFail($id);

        return view('navbar.secciones.editar', compact('secciones', 'seccion'));
    }

    // ---------------------------------------------------------
    // ACTUALIZAR
    // ---------------------------------------------------------
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|max:5120',
            'archivos.*' => 'nullable|file|max:10240',

            'cuadros.*.id' => 'nullable|integer',
            'cuadros.*.titulo' => 'nullable|string|max:255',
            'cuadros.*.autor' => 'nullable|string|max:255',
            'cuadros.*.archivo' => 'nullable|file|max:10240'
        ]);

        $seccion = NavbarSeccion::findOrFail($id);
        $data = $request->only(['nombre', 'descripcion']);

        if ($request->hasFile('imagen')) {
            if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
                Storage::disk('public')->delete($seccion->imagen);
            }

            $data['imagen'] = $request->file('imagen')->store('navbar_secciones', 'public');
        }

        $seccion->update($data);

        $this->guardarArchivos($request, $seccion);
        $this->guardarCuadrosArray($request, $seccion);

        return redirect()->route('navbar.secciones.mostrar', $seccion->id)
                         ->with('success', 'Sección actualizada correctamente.');
    }

    // ---------------------------------------------------------
    // ELIMINAR
    // ---------------------------------------------------------
    public function borrar($id)
    {
        $seccion = NavbarSeccion::with(['cuadros', 'archivos'])->findOrFail($id);

        // Borrar imagen principal
        if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
            Storage::disk('public')->delete($seccion->imagen);
        }

        // Asegurar que siempre sean iterables
        $cuadros = $seccion->cuadros ?? [];
        if (!is_iterable($cuadros)) $cuadros = [];

        $archivos = $seccion->archivos ?? [];
        if (!is_iterable($archivos)) $archivos = [];

        // Borrar cuadros
        foreach ($cuadros as $cuadro) {
            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }
            $cuadro->delete();
        }

        // Borrar archivos sueltos
        foreach ($archivos as $archivo) {
            if ($archivo->archivo && Storage::disk('public')->exists($archivo->archivo)) {
                Storage::disk('public')->delete($archivo->archivo);
            }
            $archivo->delete();
        }

        // Borrar la sección
        $seccion->delete();

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección eliminada correctamente.');
    }

    // ---------------------------------------------------------
    // PRIVADAS
    // ---------------------------------------------------------

    private function guardarArchivos(Request $request, $seccion)
    {
        $archivos = $request->file('archivos');

        // Garantizar array
        if (!is_array($archivos)) {
            $archivos = [];
        }

        foreach ($archivos as $archivo) {
            if (!$archivo || !$archivo->isValid()) continue;

            $ruta = $archivo->store('archivos_seccion', 'public');

            $seccion->archivos()->create([
                'archivo' => $ruta,
                'nombre_real' => $archivo->getClientOriginalName()
            ]);
        }
    }

    private function guardarCuadrosArray(Request $request, $seccion)
    {
        $cuadros = $request->cuadros ?? [];

        // Garantizar array
        if (!is_array($cuadros)) {
            $cuadros = [];
        }

        $idsExistentes = $seccion->cuadros()->pluck('id')->toArray();
        $idsRecibidos = [];

        foreach ($cuadros as $c) {
            $id = $c['id'] ?? 0;
            $idsRecibidos[] = $id;

            $titulo = $c['titulo'] ?? '';
            $autor = $c['autor'] ?? '';
            $archivo = $c['archivo'] ?? null;

            // -----------------------------------
            // ACTUALIZAR
            // -----------------------------------
            if ($id > 0) {
                $cuadro = Cuadro::find($id);
                if (!$cuadro) continue;

                $cuadro->titulo = $titulo;
                $cuadro->autor = $autor;

                if ($archivo && $archivo->isValid()) {
                    if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                        Storage::disk('public')->delete($cuadro->archivo);
                    }

                    $cuadro->archivo = $archivo->store('cuadros', 'public');
                    $cuadro->nombre_real = $archivo->getClientOriginalName();
                }

                $cuadro->save();
            }

            // -----------------------------------
            // CREAR NUEVO
            // -----------------------------------
            if ($id == 0) {
                if ($titulo == '' && $autor == '' && !$archivo) continue;

                $nuevo = [
                    'titulo' => $titulo,
                    'autor'  => $autor
                ];

                if ($archivo && $archivo->isValid()) {
                    $nuevo['archivo'] = $archivo->store('cuadros', 'public');
                    $nuevo['nombre_real'] = $archivo->getClientOriginalName();
                }

                $seccion->cuadros()->create($nuevo);
            }
        }

        // -----------------------------------
        // ELIMINAR LOS QUE YA NO ESTÁN
        // -----------------------------------
        $paraBorrar = array_diff($idsExistentes, array_filter($idsRecibidos));

        foreach ($paraBorrar as $idBorrar) {
            $cuadro = Cuadro::find($idBorrar);
            if (!$cuadro) continue;

            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }

            $cuadro->delete();
        }
    }
}
