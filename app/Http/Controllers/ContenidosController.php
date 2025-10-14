<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\secciones;
use App\Models\contenidos;

class ContenidosController extends Controller
{
    public function crear() 
        {
            return view('Contenidos.contenidos')
                ->with('secciones', secciones::all());
        }

    public function guardar(Request $req){
        //dd($req->all());
        $contenido = new contenidos();

        $contenido->titulo= $req->titulo;
        $contenido->descipcion = $req->descripcion;
        $contenido->estado = 'ACTIVO';
        $contenido->seccion_id = intval($req->seccion_id);

        $contenido->save();
        return redirect('/contenidos/listar');
    }

    public function listar()
    {
        return view('/Contenidos/listado')
            ->with('contenidos', contenido::with('secciones')->get());
    }

    public function editar($id)
    {
        return view('/Contenidos/editar')
            ->with('contenido', contenidos::find($id))
            ->with('secciones', secciones::all());
    }

    public function actualizar($id, Request $req)
    {
        $contenido = Contenido::find($id);

        $contenido->Titulo = $req->titulo;
        $contenido->descripcion = $req->descripcion;
        $contenido->estado = 'ACTIVO';
        $contenido->archivo_id = intval($req->archivo_id);

        $contenido->save();
        return redirect('/contenidos/listar');
    }

    public function mostrar($id)
    {
        return view('/Contenidos/mostrar')
            ->with('contenido', contenido::with('contenidos')->find($id));
    }

    public function borrar($id)
    {
        $contenido = contenido::find($id);
        $contenido->estado = 'INACTIVO';
        $contenido->save();
        return redirect('/contenidos/listar');
    }
}
