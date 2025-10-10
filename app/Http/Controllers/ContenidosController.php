<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\archivos;
use App\Models\contenidos;

class ContenidosController extends Controller
{
    public function crear()
        {
            return view('Contenidos.contenidos')
                ->with('archivos', archivos::all());
        }

    public function guardar(Request $req){
        //dd($req->all());
        $contenido = new contenidos();

        $contenido->titulo= $req->nombre;
        $contenido->descipcion = $req->apellido;
        $contenido->estado = 'ACTIVO';
        $contenido->archivo_id = intval($req->archivo_id);

        $contenido->save();
        return redirect('/contenidos/listar');
    }

    public function listar()
    {
        return view('/Contenidos/listado')
            ->with('contenidos', contenido::with('archivos')->get());
    }

    public function editar($id)
    {
        return view('/Contenidos/editar')
            ->with('contenido', contenidos::find($id))
            ->with('archivos', archivos::all());
    }

    public function actualizar($id, Request $req)
    {
        $proveedor = Proveedor::find($id);

        $contenido->Titulo = $req->titulo;
        $contenido->descripcion = $req->descripcion;
        $contenido->estado = 'ACTIVO';
        $contenido->archivo_id = intval($req->archivo_id);

        $proveedor->save();
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
