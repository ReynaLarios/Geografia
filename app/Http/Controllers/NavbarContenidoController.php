<?php

namespace App\Http\Controllers;

use App\Models\NavbarContenido;
use App\Models\NavbarSeccion;
use Illuminate\Http\Request;

class NavbarContenidosController extends Controller {
    public function crear($seccion_id) {
        return view('navbar.contenidos.crear', compact('seccion_id'));
    }

    public function guardar(Request $request) {
        NavbarContenido::create($request->all());
        return redirect()->back()->with('success','Contenido agregado');
    }

    public function editar(NavbarContenido $contenido) {
        return view('navbar.contenidos.editar', compact('contenido'));
    }

    public function actualizar(Request $request, NavbarContenido $contenido) {
        $contenido->update($request->all());
        return redirect()->back()->with('success','Contenido actualizado');
    }

    public function borrar(NavbarContenido $contenido) {
        $contenido->delete();
        return redirect()->back()->with('success','Contenido borrado');
    }
}
