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
    // Traemos únicamente las NavbarSecciones
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

    // Guardar imagen principal
    $rutaImagen = $request->hasFile('imagen') 
        ? $request->file('imagen')->store('navbar_contenidos', 'public') 
        : null;

    // Generar slug único
    $slugBase = Str::slug($request->titulo);
    $slug = $slugBase;
    $contador = 1;
    while (NavbarContenido::where('slug', $slug)->exists()) {
        $slug = $slugBase . '-' . $contador;
        $contador++;
    }

    // Crear contenido
    $contenido = NavbarContenido::create([
        'navbar_seccion_id' => $request->navbar_seccion_id,
        'titulo' => $request->titulo,
        'descripcion' => $request->descripcion,
        'imagen' => $rutaImagen,
        'slug' => $slug,
    ]);

    // Archivos adicionales
    foreach ($request->file('archivos') ?? [] as $archivo) {
        $contenido->archivos()->create([
            'nombre' => $archivo->getClientOriginalName(),
            'ruta' => $archivo->store('archivos_navbar', 'public'),
            'tipo' => $archivo->getClientOriginalExtension(),
        ]);
    }

    // Cuadros con archivos
    $this->guardarCuadros($request, $contenido);

    return redirect()->route('navbar.contenidos.index')
                     ->with('success', 'Contenido creado correctamente.');
}

    

public function editar($id)
{
    $contenido = NavbarContenido::with(['seccion', 'archivos', 'cuadros.archivos'])->findOrFail($id);

    $navbarSecciones = NavbarSeccion::all();

    return view('navbar.contenidos.editar', compact('contenido', 'navbarSecciones'));
}
    // ================== ACTUALIZAR ==================
    public function actualizar(Request $request, $id)
    {
        $contenido = NavbarContenido::with(['cuadros.archivos', 'archivos'])->findOrFail($id);

        $request->validate([
            'navbar_seccion_id' => 'required|exists:navbar_secciones,id',
            'titulo' => 'required|string|max:255',
        ]);

        // Eliminar imagen principal si se solicitó
        if ($request->input('eliminar_imagen') == 1 && $contenido->imagen) {
            if (Storage::disk('public')->exists($contenido->imagen)) {
                Storage::disk('public')->delete($contenido->imagen);
            }
            $contenido->imagen = null;
        }

        // Actualizar imagen si subieron nueva
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

        // Archivos a eliminar
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

        // Archivos nuevos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $contenido->archivos()->create([
                    'nombre' => $archivo->getClientOriginalName(),
                    'ruta' => $archivo->store('archivos_navbar', 'public'),
                    'tipo' => $archivo->getClientOriginalExtension(),
                ]);
            }
        }

        // Cuadros
        if ($request->has('cuadros')) {
            $idsRecibidos = collect($request->cuadros)->pluck('id')->filter()->all();
            $idsExistentes = $contenido->cuadros->pluck('id')->all();

            // Borrar cuadros que ya no existen
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

            // Crear o actualizar cuadros
            $this->guardarCuadros($request, $contenido, true);
        }

        return redirect()->route('navbar.contenidos.index')
                         ->with('success', 'Contenido actualizado correctamente.');
    }

    // ================== BORRAR ==================
    public function borrar($id)
    {
        $contenido = NavbarContenido::with(['archivos', 'cuadros.archivos'])->findOrFail($id);

        // Borrar imagen principal
        if ($contenido->imagen && Storage::disk('public')->exists($contenido->imagen)) {
            Storage::disk('public')->delete($contenido->imagen);
        }

        // Borrar archivos
        foreach ($contenido->archivos as $archivo) {
            if (Storage::disk('public')->exists($archivo->ruta)) {
                Storage::disk('public')->delete($archivo->ruta);
            }
            $archivo->delete();
        }

        // Borrar cuadros
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

    // ================== MOSTRAR ==================
    public function mostrar($id)
    {
        $contenido = NavbarContenido::with(['seccion', 'archivos', 'cuadros.archivos'])->findOrFail($id);
        return view('navbar.contenidos.mostrar', compact('contenido'));
    }

    // ================== MÉTODO AUXILIAR PARA CUADROS ==================
    protected function guardarCuadros(Request $request, NavbarContenido $contenido, $actualizar = false)
{
    if (!$request->has('cuadros')) return;

    foreach ($request->cuadros as $index => $cuadroData) {

        $id = $cuadroData['id'] ?? null;
        $titulo = $cuadroData['titulo'] ?? null;
        $autor  = $cuadroData['autor'] ?? null;

        // Actualizar cuadro existente
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
        } else { // Crear nuevo cuadro
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