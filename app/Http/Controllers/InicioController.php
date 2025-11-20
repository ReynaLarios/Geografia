<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inicio;
use App\Models\Archivo;
use App\Models\Carrusel;
use Illuminate\Support\Facades\Storage;


class InicioController extends Controller
{
  public function index()
{
    $noticias = Inicio::with('archivos')->get();
   $imagenesCarrusel = Carrusel::all(); // así siempre
return view('Inicio.index', compact('noticias', 'imagenesCarrusel'));

}



    // Formulario de creación
    public function create()
    {
        return view('Inicio.create');
    }

    // Guardar noticia
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'archivos.*' => 'nullable|file|max:5120',
        ]);

        $inicio = new Inicio();
        $inicio->titulo = $request->titulo;
        $inicio->descripcion = $request->descripcion ?? '';

        // Imagen principal
        if ($request->hasFile('imagen')) {
            $inicio->imagen = $request->file('imagen')->store('inicio', 'public');
        }

        $inicio->save();

        // Archivos polimórficos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $inicio->archivos()->create([
                    'nombre_real' => $archivo->getClientOriginalName(),
                    'archivo' => $archivo->store('archivos', 'public'),
                ]);
            }
        }

        return redirect()->route('inicio.index')->with('success', 'Noticia creada correctamente.');
    }

    // Formulario de edición
    public function edit($id)
    {
        $noticia = Inicio::with('archivos')->findOrFail($id);
        return view('Inicio.edit', compact('noticia'));
    }

    // Actualizar noticia
    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'archivos.*' => 'nullable|file|max:5120',
        ]);

        $noticia = Inicio::findOrFail($id);
        $noticia->titulo = $request->titulo;
        $noticia->descripcion = $request->descripcion;

        // Imagen principal
        if ($request->hasFile('imagen')) {
            if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
                Storage::disk('public')->delete($noticia->imagen);
            }
            $noticia->imagen = $request->file('imagen')->store('inicio', 'public');
        }

        $noticia->save();

        // Archivos nuevos
        if ($request->hasFile('archivos')) {
            foreach ($request->file('archivos') as $archivo) {
                $noticia->archivos()->create([
                    'nombre_real' => $archivo->getClientOriginalName(),
                    'archivo' => $archivo->store('archivos', 'public'),
                ]);
            }
        }

        return redirect()->route('inicio.index')->with('success', 'Noticia actualizada correctamente.');
    }

    // Eliminar noticia y archivos
    public function destroy($id)
    {
        $noticia = Inicio::with('archivos')->findOrFail($id);

        // Borrar imagen principal
        if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
            Storage::disk('public')->delete($noticia->imagen);
        }

        // Borrar archivos relacionados
        foreach ($noticia->archivos as $archivo) {
            if ($archivo->archivo && Storage::disk('public')->exists($archivo->archivo)) {
                Storage::disk('public')->delete($archivo->archivo);
            }
            $archivo->delete();
        }

        $noticia->delete();

        return redirect()->route('inicio.index')->with('success', 'Noticia eliminada correctamente.');
    }

    // --- Métodos del Carrusel ---
    public function createImagen()
    {
        return view('Inicio.createImagen');
    }

    public function storeImagen(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $ruta = $request->file('imagen')->store('imagenes', 'public');
        Carrusel::create(['imagen' => $ruta]);

        return redirect()->route('inicio.index')->with('success', 'Imagen agregada correctamente.');
    }

    public function editImagen($id)
    {
        $imagen = Carrusel::findOrFail($id);
        return view('Inicio.editImagen', compact('imagen'));
    }

    public function updateImagen(Request $request, $id)
    {
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagen = Carrusel::findOrFail($id);

        if ($request->hasFile('imagen')) {
            if ($imagen->imagen && Storage::disk('public')->exists($imagen->imagen)) {
                Storage::disk('public')->delete($imagen->imagen);
            }
            $imagen->imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $imagen->save();

        return redirect()->route('inicio.index')->with('success', 'Imagen actualizada correctamente.');
    }

    public function destroyImagen($id)
    {
        $imagen = Carrusel::findOrFail($id);

        if ($imagen->imagen && Storage::disk('public')->exists($imagen->imagen)) {
            Storage::disk('public')->delete($imagen->imagen);
        }

        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente.');
    }
}
