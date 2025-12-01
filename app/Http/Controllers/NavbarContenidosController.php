<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NavbarContenido;
use App\Models\NavbarSeccion;
use App\Models\Archivo;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NavbarContenidosController extends Controller
{
    
    public function index()
    {
        $contenidos = NavbarContenido::with('seccion')->get();
        return view('navbar.contenidos.index', compact('contenidos'));
    }

    
public function crear(Request $request)
{
    
    $navbarSecciones = NavbarSeccion::all();

    return view('navbar.contenidos.crear', [
        'navbarSecciones' => $navbarSecciones,
        'seccionId' => $request->seccion_id ?? null
    ]);
}

public function guardar(Request $request)
{
    $request->validate([
        'navbar_seccion_id' => 'required|exists:navbar_secciones,id',
        'titulo' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:5120',
        'archivos.*' => 'nullable|file|max:10240',
        'cuadros' => 'nullable|array',
    ]);

    $rutaImagen = $request->hasFile('imagen') 
        ? $request->file('imagen')->store('navbar_contenidos', 'public') 
        : null;


    $slugBase = Str::slug($request->titulo);
    $slug = $slugBase;
    $contador = 1;
    while (NavbarContenido::where('slug', $slug)->exists()) {
        $slug = $slugBase . '-' . $contador;
        $contador++;
    }

    $contenido = NavbarContenido::create([
        'navbar_seccion_id' => $request->navbar_seccion_id,
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'imagen' => $rutaImagen,
        'slug' => $slug,
    ]);


    foreach ($request->file('archivos') ?? [] as $archivo) {
        $contenido->archivos()->create([
            'nombre' => $archivo->getClientOriginalName(),
            'ruta' => $archivo->store('archivos_navbar', 'public'),
            'tipo' => $archivo->getClientOriginalExtension(),
        ]);
    }

   
    $this->guardarCuadros($request, $contenido);

    return redirect()->route('navbar.contenidos.index')
                     ->with('success', 'Contenido creado correctamente.');
}

    

public function editar($slug)
{
    $contenido = NavbarContenido::with(['seccion', 'archivos', 'cuadros.archivos'])->where('slug', $slug)
                          ->firstOrFail();

    $navbarSecciones = NavbarSeccion::all();

    return view('navbar.contenidos.editar', compact('contenido', 'navbarSecciones'));
}
    public function actualizar(Request $request, $slug)
    {
        $contenido = NavbarContenido::with(['cuadros.archivos', 'archivos'])->where('slug', $slug)
                          ->firstOrFail();
        $request->validate([
 'navbar_seccion_id' => 'required|exists:navbar_secciones,id',
            'titulo' => 'required|string|max:255',
        ]);

        
        if ($request->input('eliminar_imagen') == 1 && $contenido->imagen) {
            if (Storage::disk('public')->exists($contenido->imagen)) {
                Storage::disk('public')->delete($contenido->imagen);
            }
            $contenido->imagen = null;
        }

      
        if ($request->hasFile('imagen')) {
            if ($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)) {
                Storage::disk('public')->delete($contenido->imagen);
            }
            $contenido->imagen = $request->file('imagen')->store('navbar_contenidos', 'public');
        }

        $contenido->navbar_seccion_id = $request->navbar_seccion_id;
        $contenido->titulo = $request->titulo;
        $contenido->descripcion = $request->descripcion;
        $contenido->save();

        
        if ($request->input('archivos_eliminar')) {
            $idsEliminar = explode(',', $request->input('archivos_eliminar'));
            foreach ($idsEliminar as $idArchivo) {
                $archivo = $contenido->archivos()->find($idArchivo);
                if ($archivo) {
                    if (Storage::disk('public')->exists($archivo->ruta)) {
                        Storage::disk('public')->delete($archivo->ruta);
                    }
                    $archivo->delete();
                }
            }
        }

  
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $contenido->archivos()->create([
                    'nombre' => $archivo->getClientOriginalName(),
                    'ruta' => $archivo->store('archivos_navbar', 'public'),
                    'tipo' => $archivo->getClientOriginalExtension(),
                ]);
            }
        }

   
        if ($request->has('cuadros')) {
            $idsRecibidos = collect($request->cuadros)->pluck('id')->filter()->all();
            $idsExistentes = $contenido->cuadros->pluck('id')->all();

            $paraBorrar = array_diff($idsExistentes, $idsRecibidos);
            foreach ($paraBorrar as $idBorrar) {
                $cuadro = Cuadro::find($idBorrar);
                if ($cuadro) {
                    if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                        Storage::disk('public')->delete($cuadro->archivo);
                    }
                    foreach ($cuadro->archivos as $archivo) {
                        if (Storage::disk('public')->exists($archivo->ruta)) {
                            Storage::disk('public')->delete($archivo->ruta);
                        }
                        $archivo->delete();
                    }
                    $cuadro->delete();
                }
            }

         
            $this->guardarCuadros($request, $contenido, true);
        }

        return redirect()->route('navbar.contenidos.index')
                         ->with('success', 'Contenido actualizado correctamente.');
    }

  
    public function borrar($slug)
{
    $contenido = NavbarContenido::
                        where('slug', $slug)
                          ->firstOrFail();
  
    if ($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)) {
        Storage::disk('public')->delete($contenido->imagen);
    }

   
    $contenido->delete();

    return back()->with('success', 'Contenido eliminado correctamente.');

       
        foreach ($contenido->archivos as $archivo) {
            if (Storage::disk('public')->exists($archivo->ruta)) {
                Storage::disk('public')->delete($archivo->ruta);
            }
            $archivo->delete();
        }

   
        foreach ($contenido->cuadros as $cuadro) {
            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }
            foreach ($cuadro->archivos as $archivo) {
                if (Storage::disk('public')->exists($archivo->ruta)) {
                    Storage::disk('public')->delete($archivo->ruta);
                }
                $archivo->delete();
            }
            $cuadro->delete();
        }

        $contenido->delete();

        return redirect()->route('navbar.contenidos.index')
                         ->with('success', 'Contenido eliminado correctamente.');
    }

  
    public function mostrar($slug)
    {
        $contenido = NavbarContenido::with(['seccion', 'archivos', 'cuadros.archivos'])->where('slug', $slug)
                          ->firstOrFail();
;
        return view('navbar.contenidos.mostrar', compact('contenido'));
    }

  
    protected function guardarCuadros(Request $request, NavbarContenido $contenido, $actualizar = false)
{
    if (!$request->has('cuadros')) return;

    foreach ($request->cuadros as $index => $cuadroData) {

        $id = $cuadroData['id'] ?? null;
        $titulo = $cuadroData['titulo'] ?? null;
        $autor  = $cuadroData['autor'] ?? null;

        if ($id && $actualizar) {
            $cuadro = Cuadro::find($id);
            if (!$cuadro) continue;

            $cuadro->titulo = $titulo;
            $cuadro->autor = $autor;

            if ($request->hasFile("cuadros.$index.archivo")) {
                if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                    Storage::disk('public')->delete($cuadro->archivo);
                }
                $cuadro->archivo = $request->file("cuadros.$index.archivo")->store('cuadros', 'public');
            }

            $cuadro->save();
        } else { 
            $rutaArchivo = $request->hasFile("cuadros.$index.archivo")
                ? $request->file("cuadros.$index.archivo")->store('cuadros', 'public')
                : null;

            $cuadro = $contenido->cuadros()->create([
                'titulo' => $titulo,
                'autor' => $autor,
                'archivo' => $rutaArchivo
            ]);
        }
    }
}
}