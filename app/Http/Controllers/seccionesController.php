<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\secciones;
use App\Models\contenidos;


class seccionesController extends Controller 
{

    public function crear()
{
    return view('formulario4.detalle_producto')
        ->with('detalles_productos', new detalle_producto())
        ->with('clientes', cliente::all());
}


    public function guardar(Request $req){ //Peticion para guardar
        // dd($req->all());
        $secciones = new secciones();

        $secciones->nombre = $req->nombre;
        $secciones->descripcion = $req->descripcion;
         $secciones->contenido_id = intval($req->contenido_id);

        $secciones->save();

        }

    //Actualizar un produto
    public function editar($id){
        return view('/formulario4/Edicion')
           ->with('secciones',secciones::find($id))
           ->with('contenido',contenido::all());
    }

    public function actualizar($id, Request $req){
        //dd($req->all());
        $seccion = detalle_producto::find($id);

        $seccion->nombre = $req->nombre;
        $seccion->codigo = $req->descripcion;
        $seccion->contenido_id = intval($req->contenido_id);
        
        
        $seccion->save();
        return redirect('/secciones/listar');
    }

    //Borrado de un producto
    public function mostrar($id){
        return view('/formulario4/mostrar')
        ->with('seccion',seccion::find($id));
    }

    public function borrar($id){
        //dd($req->all());
        $seccion = seccion::find($id);
        $seccion->save();
        return redirect('/detalles_productos/listar');
    }
}
