<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inicio;
use App\Models\Carrusel;
use Illuminate\Support\Facades\Storage;

class InicioController extends Controller
{
    public function index()
    {
        $noticias = Inicio::all();              // Todas las noticias
        $imagenesCarrousel = Carrusel::all();   // Todas las imágenes del carrousel

        return view('Inicio.index', compact('noticias', 'imagenesCarrousel'));
    }

    public function show($id)
    {
        $inicio = Inicio::findOrFail($id);
        return view('Inicio.show', compact('inicio'));
    }

    public function create()
    {
        return view('Inicio.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string',
            'imagen' => 'required|image',
            'descripcion' => 'nullable|string',
        ]);

        $inicio = new Inicio();
        $inicio->titulo = $request->titulo;
        $inicio->descripcion = $request->descripcion ?? '';

        if ($request->hasFile('imagen')) {
            $path = $request->file('imagen')->store('public/inicio');
            $inicio->imagen = basename($path);
        }

        $inicio->save();

        return redirect()->route('inicio.index')->with('success', 'Imagen agregada correctamente');
    }

    public function edit($id)
    {
        $noticia = Inicio::findOrFail($id);
        return view('Inicio.edit', compact('noticia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
        ]);

        $noticia = Inicio::findOrFail($id);
        $noticia->titulo = $request->titulo;
        $noticia->descripcion = $request->descripcion;
        $noticia->save();

        return redirect()->route('inicio.index')->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $noticia = Inicio::findOrFail($id);
        $noticia->delete();
        return redirect()->route('inicio.index')->with('success', 'Noticia eliminada correctamente.');
    }

    // --- Métodos del Carrousel ---

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
