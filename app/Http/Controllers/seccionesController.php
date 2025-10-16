<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\secciones; 

class SeccionesController extends Controller
{
    public function crear()
    {
        return view('secciones.secciones');
    }

    public function guardar(Request $req)
    {
        $seccion = new secciones();

        $seccion->nombre = $req->nombre;
        $seccion->descripcion = $req->descripcion;
        $seccion->save();
        return redirect('/secciones/listar');
    }

    public function listar()
    {
        $secciones = secciones::all();
        return view('secciones.listado', compact('secciones'));
    }

    public function editar($id)
    {
        $seccion = secciones::find($id);
        return view('secciones.editar', compact('seccion'));
    }

    public function actualizar($id, Request $req)
    {
        $seccion = secciones::find($id);

        $seccion->nombre = $req->nombre;
        $seccion->descripcion = $req->descripcion;

        $seccion->save();
        return redirect('/secciones/listar');
    }

    public function mostrar($id)
    {
        $seccion = secciones::find($id);
        return view('secciones.mostrar', compact('seccion'));
    }

    public function borrar($id)
    {
        $seccion = secciones::find($id);
        $seccion->save();

        return redirect('/secciones/listar');
    }
}
