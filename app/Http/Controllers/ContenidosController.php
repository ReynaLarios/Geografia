<?php

namespace App\Http\Controllers;

use App\Models\Contenidos;
use App\Models\Secciones;
use App\Models\Archivo;
use App\Models\Cuadro;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ContenidosController extends Controller
{
    public function listar()
    {
        $contenidos = Contenidos::with(['seccion','archivos','cuadros'])->get();
        return view('Contenidos.contenidos', compact('contenidos'));
    }

    public function crear()
    {
        $secciones = Secciones::all();
        return view('Contenidos.contenidos', compact('secciones'));
    }

   
    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'seccion_id' => 'required|exists:secciones,id',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadros.*.titulo' => 'nullable|string|max:255',
            'cuadros.*.autor' => 'nullable|string|max:255',
            'cuadros.*.archivo' => 'nullable|file|max:5120'
        ]);

        $datos = $request->only(['titulo','descripcion','seccion_id']);

        if ($request->hasFile('imagen')) {
            $datos['imagen'] = $request->file('imagen')->store('contenidos','public');
        }

        $contenido = Contenidos::create($datos);

       
        if($request->hasFile('archivos')) {
            foreach($request->file('archivos') as $file) {
                $contenido->archivos()->create([
                    'nombre' => $file->getClientOriginalName(),
                    'ruta' => $file->store('archivos','public'),
                    'tipo' => $file->getClientOriginalExtension()
                ]);
            }
        }

       
        if($request->filled('cuadros')) {
            foreach($request->cuadros as $item) {
                if($item['titulo'] || $item['autor'] || isset($item['archivo'])) {
                    $archivoPath = isset($item['archivo']) ? $item['archivo']->store('cuadros','public') : null;
                    Cuadro::create([
                        'titulo' => $item['titulo'],
                        'autor' => $item['autor'],
                        'archivo' => $archivoPath,
                        'mostrar' => true,
                        'contenido_id' => $contenido->id
                    ]);
                }
            }
        }

        return redirect()->route('contenidos.listado')->with('success','Contenido creado correctamente.');
    }

 
    public function editar($id)
    {
        $contenido = Contenidos::with(['archivos','cuadros'])->findOrFail($id);
        $secciones = Secciones::all();
        return view('Contenidos.editar', compact('contenido','secciones'));
    }

    
    public function actualizar(Request $request, $id)
    {
        $contenido = Contenidos::with(['cuadros'])->findOrFail($id);

        $request->validate([
            'titulo' => 'required|string|max:255',
            'seccion_id' => 'required|exists:secciones,id',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'archivos.*' => 'nullable|file|max:10240',
            'cuadros.*.titulo' => 'nullable|string|max:255',
            'cuadros.*.autor' => 'nullable|string|max:255',
            'cuadros.*.archivo' => 'nullable|file|max:5120'
        ]);

        $datos = $request->only(['titulo','descripcion','seccion_id']);

        if($request->hasFile('imagen')) {
            if($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)) {
                Storage::disk('public')->delete($contenido->imagen);
            }
            $datos['imagen'] = $request->file('imagen')->store('contenidos','public');
        }

        $contenido->update($datos);

        // Archivos
        if($request->hasFile('archivos')) {
            foreach($request->file('archivos') as $file) {
                $contenido->archivos()->create([
                    'nombre' => $file->getClientOriginalName(),
                    'ruta' => $file->store('archivos','public'),
                    'tipo' => $file->getClientOriginalExtension()
                ]);
            }
        }

        
        if($request->filled('cuadros')) {
            foreach($request->cuadros as $idCuadro => $item) {
                if(isset($item['id'])) {
                    $cuadro = Cuadro::find($item['id']);
                    if($cuadro) {
                        $archivoPath = isset($item['archivo']) ? $item['archivo']->store('cuadros','public') : $cuadro->archivo;
                        $cuadro->update([
                            'titulo' => $item['titulo'],
                            'autor' => $item['autor'],
                            'archivo' => $archivoPath,
                            'mostrar' => true
                        ]);
                    }
                } else {
                    if($item['titulo'] || $item['autor'] || isset($item['archivo'])) {
                        $archivoPath = isset($item['archivo']) ? $item['archivo']->store('cuadros','public') : null;
                        Cuadro::create([
                            'titulo' => $item['titulo'],
                            'autor' => $item['autor'],
                            'archivo' => $archivoPath,
                            'mostrar' => true,
                            'contenido_id' => $contenido->id
                        ]);
                    }
                }
            }
        }

        return redirect()->route('contenidos.listado')->with('success','Contenido actualizado correctamente.');
    }

    public function mostrar($id)
    {
        $contenido = Contenidos::with(['archivos','cuadros'])->findOrFail($id);
        return view('Contenidos.mostrar', compact('contenido'));
    }

    public function borrar($id)
    {
        $contenido= Secciones::findOrFail($id);
        $contenido->delete();

        return redirect()->route('contenidos.listado')->with('success', 'Sección eliminada correctamente.');
    }
}
