<?php

namespace App\Http\Controllers;

use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;
use Illuminate\Http\Request;

class NavbarSeccionesController extends Controller
{
    /** Mostrar todas las secciones del navbar **/
    public function index()
    {
        $navbarSecciones = NavbarSeccion::with('hijos')->get();
        return view('navbar.secciones.index', compact('navbarSecciones'));
    }

    /** Mostrar formulario para crear una nueva sección **/
    public function crear()
    {
        return view('navbar.secciones.crear');
    }

    /** Guardar una nueva sección **/
    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255'
        ]);

        NavbarSeccion::create([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección creada correctamente.');
    }

    /** Mostrar formulario para editar una sección existente **/
    public function editar(NavbarSeccion $navbar_seccion)
    {
        return view('navbar.secciones.editar', compact('navbar_seccion'));
    }

    /** Actualizar los datos de una sección **/
    public function actualizar(Request $request, NavbarSeccion $navbar_seccion)
    {
        $request->validate([
    'nombre' => 'required|string|max:100',
    'ruta' => 'nullable|string|max:255',
]);


        $navbar_seccion->update([
            'nombre' => $request->nombre,
        ]);

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección actualizada correctamente.');
    }

    /** Eliminar una sección **/
    public function borrar(NavbarSeccion $navbar_seccion)
    {
        $navbar_seccion->delete();

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección eliminada correctamente.');
    }

    /** Mostrar formulario para crear un submenú (contenido) **/
    public function crearContenido(NavbarSeccion $navbar_seccion)
    {
        return view('navbar.contenidos.crear', compact('navbar_seccion'));
    }

    /** Guardar un nuevo submenú **/
    public function guardarContenido(Request $request, NavbarSeccion $navbar_seccion)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruta' => 'nullable|string|max:255'
        ]);

        $navbar_seccion->hijos()->create([
            'nombre' => $request->nombre,
            'ruta' => $request->ruta,
        ]);

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Submenú creado correctamente.');
    }

    /** Editar contenido existente **/
    public function editarContenido(NavbarContenido $navbar_contenido)
    {
        return view('navbar.contenidos.editar', compact('navbar_contenido'));
    }

    /** Actualizar contenido **/
    public function actualizarContenido(Request $request, NavbarContenido $navbar_contenido)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'ruta' => 'nullable|string|max:255'
        ]);

        $navbar_contenido->update([
            'nombre' => $request->nombre,
            'ruta' => $request->ruta,
        ]);

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Submenú actualizado correctamente.');
    }

    /** Eliminar contenido **/
    public function borrarContenido(NavbarContenido $navbar_contenido)
    {
        $navbar_contenido->delete();

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Submenú eliminado correctamente.');
    }
    public function mostrarNavbar()
{
    $navbarSecciones = \App\Models\NavbarSeccion::with('hijos')->get();
    return view('base.layout', compact('navbarSecciones'));
}

}
