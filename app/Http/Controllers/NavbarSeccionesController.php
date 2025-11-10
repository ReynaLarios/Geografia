<?php

namespace App\Http\Controllers;

use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;
use Illuminate\Http\Request;

class NavbarSeccionesController extends Controller
{
    public function index()
    {
        $navbarSecciones = NavbarSeccion::with('contenidosNavbar')->get();
        return view('navbar.secciones.index', compact('navbarSecciones'));
    }

    public function crear()
    {
        return view('navbar.secciones.guardar');
    }

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

    public function editarSeccion(NavbarSeccion $seccion)
    {
        return view('navbar.secciones.edit', compact('seccion'));
    }

    public function actualizarSeccion(Request $request, NavbarSeccion $seccion)
    {
        $request->validate([
            'nombre' => $request->nombre,
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:2048',
        ]);

        $seccion->update([
            'nombre' => $request->nombre,
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:2048',
        ]);

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección actualizada correctamente.');
    }

    public function borrarSeccion(NavbarSeccion $seccion)
    {
        $seccion->delete();

        return redirect()->route('navbar.secciones.index')
                         ->with('success', 'Sección eliminada correctamente.');
    }
}
