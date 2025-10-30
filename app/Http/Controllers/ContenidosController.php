<?php

namespace App\Http\Controllers;

use App\Models\Contenidos;
use App\Models\Secciones;
use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContenidosController extends Controller
{
    public function listar()
    {
        $contenidos = Contenidos::with('seccion','archivos')->get();
        $secciones = Secciones::all();
        return view('contenidos.listado', compact('contenidos', 'secciones'));
    }
    public function crear()
    {
        $secciones = Secciones::all();
        return view('contenidos.contenidos', compact('secciones'));
    }
    public function guardar(Request $request)
    {
        $request->validate([
            'seccion_id' => 'required|exists:secciones,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'archivos.*' => 'nullable|file|max:10240'
        ]);

        $datos = $request->only(['seccion_id','titulo','descripcion']);

        if($request->hasFile('imagen')){
            $datos['imagen'] = $request->file('imagen')->store('contenidos','public');
        }

        $contenido = Contenidos::create($datos);

        if($request->hasFile('archivos')){
            foreach($request->file('archivos') as $file){
                $ruta = $file->store('archivos','public');
                $contenido->archivos()->create([
                    'nombre' => $file->getClientOriginalName(),
                    'ruta' => $ruta,
                    'tipo' => $file->getClientOriginalExtension()
                ]);
            }
        }

        return redirect()->route('contenidos.listar')->with('success','Contenido creado correctamente');
    }

    public function editar($id)
    {
        $contenido = Contenidos::with('archivos')->findOrFail($id);
        $secciones = Secciones::all();
        $archivos = $contenido->archivos;
        return view('contenidos.contenidos', compact('contenido','secciones','archivos'));
    }

    public function actualizar(Request $request, $id)
    {
        $contenido = Contenidos::findOrFail($id);

        $request->validate([
            'seccion_id' => 'required|exists:secciones,id',
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'archivos.*' => 'nullable|file|max:10240'
        ]);

        $datos = $request->only(['seccion_id','titulo','descripcion']);

        if($request->hasFile('imagen')){
         
            if($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)){
                Storage::disk('public')->delete($contenido->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('contenidos','public');
        }

        $contenido->update($datos);

        if($request->hasFile('archivos')){
            foreach($request->file('archivos') as $file){
                $ruta = $file->store('archivos','public');
                $contenido->archivos()->create([
                    'nombre' => $file->getClientOriginalName(),
                    'ruta' => $ruta,
                    'tipo' => $file->getClientOriginalExtension()
                ]);
            }
        }

        return redirect()->route('contenidos.listar')->with('success','Contenido actualizado correctamente');
    }


    public function mostrar($id)
    {
        $contenido = Contenidos::with('seccion','archivos')->findOrFail($id);
        $seccion = $contenido->seccion; 
        $archivos = $contenido->archivos;
        return view('contenidos.mostrar', compact('contenido','seccion','archivos'));
    }

    public function borrar($id)
    {
        $contenido = Contenidos::findOrFail($id);

        if($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)){
            Storage::disk('public')->delete($contenido->imagen);
        }

        foreach($contenido->archivos as $archivo){
            if(Storage::disk('public')->exists($archivo->ruta)){
                Storage::disk('public')->delete($archivo->ruta);
            }
            $archivo->delete();
        }

        $contenido->delete();

        return redirect()->route('contenidos.listar')->with('success','Contenido eliminado correctamente');
    }
}
