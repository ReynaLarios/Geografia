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

    public function crear()
    {
        return view('navbar.secciones.guardar');
    }

        public function guardar(NavbarSeccion $navbar_seccion)

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

   
    public function editar(NavbarSeccion $navbar_seccion)
    {
        return view('navbar.secciones.editar', compact('navbar_seccion'));
    }


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

   
    public function borrar(NavbarSeccion $navbar_seccion)
    {
        $navbar_seccion->delete();

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección eliminada correctamente.');
    }

    public function crearContenido(NavbarSeccion $navbar_seccion)
    {
        return view('navbar.contenidos.crear', compact('navbar_seccion'));
    }


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

    public function editarContenido(NavbarContenido $navbar_contenido)
    {
        return view('navbar.contenidos.editar', compact('navbar_contenido'));
    }

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
