<?php

namespace App\Http\Controllers;

use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;
use Illuminate\Http\Request;

class NavbarContenidosController extends Controller
{
    public function crear(NavbarSeccion $seccion)
{
    return view('navbar.contenidos.crear', compact('seccion'));
}

public function guardar(Request $request, NavbarSeccion $seccion)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['titulo', 'descripcion']);
    
    if($request->hasFile('imagen')) {
        $data['imagen'] = $request->file('imagen')->store('navbar', 'public');
    }

    $seccion->contenidosNavbar()->create($data);

    return redirect()->route('navbar.secciones.index')->with('success', 'Submenú agregado correctamente.');
}

public function actualizar(Request $request, NavbarContenido $contenido)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:2048',
    ]);

    $data = $request->only(['titulo', 'descripcion']);

    if($request->hasFile('imagen')) {
        $data['imagen'] = $request->file('imagen')->store('navbar', 'public');
    }

    $contenido->update($data);

    return redirect()->route('navbar.secciones.index')->with('success', 'Submenú actualizado correctamente.');
}

/** ✅ BORRAR SUBMENÚ */
public function borrar(NavbarContenido $contenido)
{
    $contenido->delete();

    return redirect()->route('navbar.secciones.index')
                     ->with('success', 'Submenú eliminado correctamente.');
}

public function editar(NavbarContenido $contenido)
{
    $navbar_contenido = $contenido; // renombramos para la vista
    return view('navbar.contenidos.editar', compact('navbar_contenido'));
}
public function store(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'url' => 'nullable|string|max:255',
        'seccion_id' => 'required|exists:navbar_seccions,id',
    ]);

    NavbarContenido::create([
        'titulo' => $request->titulo,
        'url' => $request->url,
        'navbar_seccion_id' => $request->navbar_seccion_id,
    ]);

    return redirect()->route('navbar.secciones.index')
                     ->with('success', 'Contenido agregado correctamente.');
}



}
