<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Secciones;
use App\Models\Contenidos;

class ContenidosController extends Controller
{
    public function crear() 
    {
        return view('Contenidos.contenidos')
            ->with('secciones', Secciones::all());
    }

    public function guardar(Request $req)
    {
        $req->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'seccion_id' => 'required|exists:secciones,id',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,mp4,pdf|max:10240',
        ]);

        $contenido = new Contenidos();
        $contenido->titulo = $req->titulo;
        $contenido->descripcion = $req->descripcion;
        $contenido->seccion_id = intval($req->seccion_id);

        if ($req->hasFile('archivo')) {
            $contenido->archivo = $req->file('archivo')->store('archivos', 'public');
        }

        $contenido->save();
        return redirect('/contenidos/listar')->with('success', 'Contenido creado correctamente');
    }

    public function listar()
    {
        return view('Contenidos.listado')
            ->with('contenidos', Contenidos::with('secciones')->get());
    }

    public function editar($id)
    {
        $contenido = Contenidos::findOrFail($id);
        $secciones = Secciones::all();

        return view('Contenidos.editar', compact('contenido', 'secciones'));
    }

    public function actualizar(Request $req, $id)
    {
        $req->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'seccion_id' => 'required|exists:secciones,id',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,mp4,pdf|max:10240',
        ]);

        $contenido = Contenidos::findOrFail($id);
        $contenido->titulo = $req->titulo;
        $contenido->descripcion = $req->descripcion;
        $contenido->seccion_id = intval($req->seccion_id);

        if ($req->hasFile('archivo')) {
            $contenido->archivo = $req->file('archivo')->store('archivos', 'public');
        }

        $contenido->save();
        return redirect()->back()->with('success', 'Contenido actualizado correctamente');
    }

    public function mostrar($id)
{
    $contenido = Contenidos::with('secciones')->findOrFail($id);
    return view('Contenidos.mostrar', compact('contenido'));
}



    public function borrar($id)
    {
        $contenido = Contenidos::findOrFail($id);
        $contenido->delete();
        return redirect('/contenidos/listar')->with('success', 'Contenido eliminado correctamente');
    }
}
