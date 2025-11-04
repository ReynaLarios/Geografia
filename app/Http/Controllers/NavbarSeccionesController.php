<?php

namespace App\Http\Controllers;

use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;
use Illuminate\Http\Request;

class NavbarSeccionesController extends Controller
{
  
    public function index()
    {
        $navbarSecciones = NavbarSeccion::with('hijos')->get();
        return view('navbar.index', compact('navbarSecciones'));
    }

    public function crear()
    {
        return view('navbar.secciones.crear');
    }

    public function guardarSeccion(Request $request)
    {
        $request->validate(['nombre' => 'required']);
        NavbarSeccion::create(['nombre' => $request->nombre]);
        return redirect()->route('navbar.index')->with('success', 'Sección creada correctamente');
    }

  
    public function editarSeccion(NavbarSeccion $seccion)
    {
        return view('navbar.editarSeccion', compact('seccion'));
    }

    public function actualizarSeccion(Request $request, NavbarSeccion $seccion)
    {
        $request->validate(['nombre' => 'required']);
        $seccion->update(['nombre' => $request->nombre]);
        return redirect()->route('navbar.index')->with('success', 'Sección actualizada');
    }


    public function borrarSeccion(NavbarSeccion $seccion)
    {
        $seccion->delete();
        return redirect()->route('navbar.index')->with('success', 'Sección eliminada');
    }

    public function crearContenido(NavbarSeccion $seccion)
    {
        return view('navbar.crearContenido', compact('seccion'));
    }

    public function guardarContenido(Request $request, NavbarSeccion $seccion)
    {
        $request->validate(['nombre' => 'required']);
        $seccion->hijos()->create([
            'nombre' => $request->nombre,
            'ruta' => $request->ruta,
        ]);
        return redirect()->route('navbar.index')->with('success', 'Contenido creado');
    }


    public function editarContenido(NavbarContenido $contenido)
    {
        return view('navbar.editarContenido', compact('contenido'));
    }

    public function actualizarContenido(Request $request, NavbarContenido $contenido)
    {
        $request->validate(['nombre' => 'required']);
        $contenido->update([
            'nombre' => $request->nombre,
            'ruta' => $request->ruta,
        ]);
        return redirect()->route('navbar.index')->with('success', 'Contenido actualizado');
    }

   
    public function borrarContenido(NavbarContenido $contenido)
    {
        $contenido->delete();
        return redirect()->route('navbar.index')->with('success', 'Contenido eliminado');
    }
}
