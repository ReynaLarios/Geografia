<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\secciones;


class seccionesController extends Controller
{
    public function crear()
        {
            return view('Secciones.secciones');
        }

    public function guardar(Request $req){
        //dd($req->all());
        $seccion = new secciones();

        $seccion->nombre= $req->nombre;
        $seccion->descripcion = $req->descripcion;
        $seccion->estado = 'ACTIVO';
      
        $seccion->save();
        return redirect('/secciones/listar');
    }

    public function listar()
    {
        return view('/secciones/listado');
    }

    public function editar($id)
    {
        return view('/secciones/editar')
            ->with('secciones', secciones::find($id));
    }

    public function actualizar($id, Request $req)
    {
        $seccion = Secciones::find($id);

        $seccion->nombre = $req->nombre;
        $seccion->descripcion = $req->descripcion;
        $seccion->estado = 'ACTIVO';
       
        $seccion->save();
        return redirect('/secciones/listar');
    }

    public function mostrar($id)
    {
        return view('/secciones/mostrar') ;
    }

    public function borrar($id)
    {
        $seccion = contenido::find($id);
        $seccion->estado = 'INACTIVO';
        $seccion->save();
        return redirect('/secciones/listar');
    }
}
