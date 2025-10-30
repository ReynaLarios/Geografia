<?php

namespace App\Http\Controllers;

use App\Models\Contenidos;
use App\Models\Secciones;
use App\Models\Archivo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContenidosController extends Controller
{
    // Mostrar todos los contenidos
    public function listar()
    {
        $contenidos = Contenidos::with('seccion','archivos')->get();
        $secciones = Secciones::all();
        return view('contenidos.listado', compact('contenidos', 'secciones'));
    }

    // Mostrar formulario para crear contenido
    public function crear()
    {
        $secciones = Secciones::all();
        return view('contenidos.contenidos', compact('secciones'));
    }

    // Guardar un nuevo contenido
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

        // Subida de imagen si existe
        if($request->hasFile('imagen')){
            $datos['imagen'] = $request->file('imagen')->store('contenidos','public');
        }

        $contenido = Contenidos::create($datos);

        // Subida de archivos si existen
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

    // Mostrar formulario para editar contenido
    public function editar($id)
    {
        $contenido = Contenidos::with('archivos')->findOrFail($id);
        $secciones = Secciones::all();
        $archivos = $contenido->archivos;
        return view('contenidos.contenidos', compact('contenido','secciones','archivos'));
    }

    // Actualizar contenido
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

        // Subida de imagen si existe
        if($request->hasFile('imagen')){
            // Borrar imagen anterior
            if($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)){
                Storage::disk('public')->delete($contenido->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('contenidos','public');
        }

        $contenido->update($datos);

        // Subida de archivos si existen
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

    // Mostrar un contenido específico
    public function mostrar($id)
    {
        $contenido = Contenidos::with('seccion','archivos')->findOrFail($id);
        $seccion = $contenido->seccion; // para sidebar
        $archivos = $contenido->archivos;
        return view('contenidos.mostrar', compact('contenido','seccion','archivos'));
    }

    // Borrar contenido
    public function borrar($id)
    {
        $contenido = Contenidos::findOrFail($id);

        // Borrar imagen principal
        if($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)){
            Storage::disk('public')->delete($contenido->imagen);
        }

        // Borrar archivos asociados
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
