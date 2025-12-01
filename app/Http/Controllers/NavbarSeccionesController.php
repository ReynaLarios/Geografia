<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\NavbarSeccion;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NavbarSeccionesController extends Controller
{
   
    public function index()
    {
        $secciones = NavbarSeccion::with(['cuadros.archivos', 'archivos'])->get();
        return view('navbar.secciones.index', compact('secciones'));
    }

    public function crear()
    {
        return view('navbar.secciones.crear');
    }



public function guardar(Request $request)
{
    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:5120',
        'archivos.*' => 'nullable|file|max:10240',
        'cuadros' => 'nullable|array',
    ]);

    $rutaImagen = $request->hasFile('imagen') ? $request->file('imagen')->store('navbar_secciones', 'public') : null;

    
    $slugBase = Str::slug($request->nombre);
    $slug = $slugBase;
    $contador = 1;
    while (NavbarSeccion::where('slug', $slug)->exists()) {
        $slug = $slugBase . '-' . $contador;
        $contador++;
    }

    $seccion = NavbarSeccion::create([
        'nombre' => $request->nombre,
        'slug' => $slug,
        'descripcion' => $request->descripcion,
        'imagen' => $rutaImagen,
    ]);

    $this->guardarArchivos($request, $seccion);
    $this->guardarCuadros($request, $seccion);

    return redirect()->route('navbar.secciones.index')
                     ->with('success', 'Sección creada correctamente.');
}


    public function editar($slug)
      {
        $seccion = NavbarSeccion::with(['cuadros','archivos'])->findOrFail($slug);
        return view('navbar.secciones.editar', compact('seccion'));
    }

   public function actualizar(Request $request, $id)
{
    $seccion = NavbarSeccion::with('cuadros', 'archivos')->findOrFail($id);

    $request->validate([
        'nombre' => 'required|string|max:255',
        'descripcion' => 'nullable|string',
        'imagen' => 'nullable|image|max:5120',
        'archivos.*' => 'nullable|file|max:10240',
        'cuadros' => 'nullable|array',
    ]);

  
    if ($request->hasFile('imagen')) {
        if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
            Storage::disk('public')->delete($seccion->imagen);
        }
        $seccion->imagen = $request->file('imagen')->store('navbar_secciones', 'public');
    }

    $seccion->nombre = $request->nombre;
    $seccion->descripcion = $request->descripcion;
    $seccion->save();

   
    if ($request->hasFile('archivos')) {
        foreach ($request->file('archivos') as $archivo) {
            $seccion->archivos()->create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta' => $archivo->store('archivos_seccion', 'public'),
                'tipo' => $archivo->getClientOriginalExtension(),
            ]);
        }
    }

   
    $cuadros = $request->input('cuadros', []);
    foreach ($cuadros as $index => $data) {
        $cuadro = isset($data['id']) && $data['id'] > 0 ? Cuadro::find($data['id']) : new Cuadro();
        $cuadro->titulo = $data['titulo'] ?? null;
        $cuadro->autor = $data['autor'] ?? null;
      

        if (isset($data['archivo']) && $request->hasFile("cuadros.$index.archivo")) {
            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }
            $cuadro->archivo = $request->file("cuadros.$index.archivo")->store('cuadros', 'public');
        }

        $cuadro->save();
    }

    return redirect()->route('navbar.secciones.index')
                     ->with('success', 'Sección actualizada correctamente.');
}


public function borrarArchivo($archivoId)
{
    $archivo = \App\Models\Archivo::findOrFail($archivoId);

    if ($archivo->ruta && Storage::disk('public')->exists($archivo->ruta)) {
        Storage::disk('public')->delete($archivo->ruta);
    }

    $archivo->delete();

    return back()->with('success', 'Archivo eliminado correctamente.');
}

public function borrarImagen($id) 
{
    $seccion = NavbarSeccion::findOrFail($id);

    if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
        Storage::disk('public')->delete($seccion->imagen);
    }

    $seccion->imagen = null;
    $seccion->save();

    return back()->with('success', 'Imagen eliminada correctamente.');
}


public function borrar($id)
{
    $seccion = NavbarSeccion::findOrFail($id);

  
    if ($seccion->imagen && Storage::disk('public')->exists($seccion->imagen)) {
        Storage::disk('public')->delete($seccion->imagen);
    }

   
    $seccion->delete();

    return back()->with('success', 'Sección eliminada correctamente.');
}

    

    public function mostrar($idOrSlug)
    {
        if (is_numeric($idOrSlug)) {
           
            $seccion = NavbarSeccion::with(['cuadros.archivos', 'archivos'])->findOrFail($idOrSlug);
        } else {
          
            $seccion = NavbarSeccion::with(['cuadros.archivos', 'archivos'])
                ->where('slug', $idOrSlug)
                ->firstOrFail();
        }

        return view('navbar.secciones.mostrar', compact('seccion'));
    }


    private function guardarArchivos(Request $request, $seccion)
    {
        foreach ($request->file('archivos') ?? [] as $archivo) {
            $seccion->archivos()->create([
                'nombre' => $archivo->getClientOriginalName(),
                'ruta' => $archivo->store('archivos_seccion', 'public'),
                'tipo' => $archivo->getClientOriginalExtension()
            ]);
        }
    }

    private function guardarCuadros(Request $request, $seccion)
{
    $titulos = $request->input('cuadro_titulo', []);
    $autores = $request->input('cuadro_autor', []);
    $ids = $request->input('cuadro_id', []);

    
    $archivos = $request->file('cuadro_archivo') ?? [];

    foreach ($titulos as $i => $titulo) {
        $id = intval($ids[$i] ?? 0);
        $tituloLimpio = isset($titulo) ? trim($titulo) : null;
        $autorLimpio = isset($autores[$i]) ? trim($autores[$i]) : null;

        $archivo = isset($archivos[$i]) ? $archivos[$i] : null;
        $hayArchivo = isset($archivo) && $archivo->isValid();

        
        if (!$tituloLimpio && !$autorLimpio && !$hayArchivo) continue;

        
        $nuevo = [];
        if ($tituloLimpio) $nuevo['titulo'] = $tituloLimpio;
        if ($autorLimpio) $nuevo['autor'] = $autorLimpio;
        if ($hayArchivo) {
            $nuevo['archivo'] = $archivo->store('cuadros', 'public');
        }

        $seccion->cuadros()->create($nuevo);
    }
}
}
