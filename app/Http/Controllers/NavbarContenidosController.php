<?php

namespace App\Http\Controllers;

use App\Models\Contenidos;
use App\Models\NavbarContenido;
use App\Models\Cuadro;
use Illuminate\Http\Request;
use App\Models\NavbarSeccion;

class NavbarContenidosController extends Controller
{
    public function index()
    {
        $contenidos = NavbarContenido::all();
        return view('navbar.contenidos.index', compact('contenidos'));
    }

    public function crear()
    {
        return view('navbar.contenidos.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required'
        ]);

        // Imagen principal
        $imagen = null;
        if ($request->hasFile('imagen')) {
            $imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        // Archivos múltiples
        $archivosGuardados = [];
        if ($request->hasFile('archivos')) {
            foreach($request->file('archivos') as $file){
                $archivosGuardados[] = $file->store('archivos', 'public');
            }
        }

        // Crear contenido
        $contenido = NavbarContenido::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $imagen,
            'archivos' => $archivosGuardados
        ]);

        // Guardar CUADROS polimórficos
        if ($request->cuadros) {
            foreach ($request->cuadros as $cuadro) {

                $archivoCuadro = null;
                if (isset($cuadro['archivo'])) {
                    $archivoCuadro = $cuadro['archivo']->store('cuadros', 'public');
                }

                Cuadro::create([
                    'cuadrobable_id' => $contenido->id,
                    'cuadrobable_type' => NavbarContenido::class,
                    'titulo' => $cuadro['titulo'] ?? '',
                    'autor' => $cuadro['autor'] ?? '',
                    'archivo' => $archivoCuadro,
                    'mostrar' => isset($cuadro['mostrar']) ? 1 : 0
                ]);
            }
        }

        return redirect()->route('navbar.contenidos.index')
            ->with('ok', 'Contenido guardado');
    }

    public function mostrar($id)
    {
        $contenido = NavbarContenido::with('cuadros')->findOrFail($id);
        return view('navbar.contenidos.mostrar', compact('contenido'));
    }

    public function editar($id)
    {
        $contenido = NavbarContenido::with('cuadros')->findOrFail($id);
        return view('navbar.contenidos.editar', compact('contenido'));
    }

    public function borrar($id)
    {
    Cuadro::where('cuadrobable_id', $id)
      ->where('cuadrobable_type', NavbarSeccion::class)
      ->get();


     
        NavbarContenido::where('id', $id)->delete();

        return back()->with('ok', 'Contenido eliminado');
    }
    public function actualizar(Request $request, $id)
{
    $contenido = Contenidos::findOrFail($id);

    $contenido->titulo = $request->input('titulo');
    $contenido->descripcion = $request->input('descripcion');

    if ($request->hasFile('imagen')) {
        $imagen = $request->file('imagen')->store('public/imagenes');
        $contenido->imagen = str_replace('public/', 'storage/', $imagen);
    }

    $contenido->save();

    return redirect()->back()->with('success', 'Contenido actualizado correctamente.');
}

}
