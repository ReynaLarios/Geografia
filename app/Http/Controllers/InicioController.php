<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inicio;
use App\Models\Archivo;
use App\Models\Carrusel;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InicioController extends Controller
{
   
    public function index()
    {
        $noticias = Inicio::with('archivos')->get();
        $imagenesCarrusel = Carrusel::all();
        return view('Inicio.index', compact('noticias', 'imagenesCarrusel'));
    }

    public function show($slug)
    {
        $noticia = Inicio::with('archivos')->findOrFail($slug);
        return view('Inicio.show', compact('noticia'));
    }

   
    public function create()
    {
        return view('Inicio.create');
    }

  
    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'nullable|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            
        ]);

        $inicio = new Inicio();
        $inicio->titulo = $request->titulo;
        $inicio->slug = Str::slug($request->titulo); 
        $inicio->descripcion = $request->descripcion ?? '';

        if ($request->hasFile('imagen')) {
            $inicio->imagen = $request->file('imagen')->store('inicio', 'public');
        }

        $inicio->save();


        return redirect()->route('inicio.index')->with('success', 'Noticia creada correctamente.');
    }

   
    public function edit($slug)
    {
        $noticia = Inicio::with('archivos')->findOrFail($slug);
        return view('Inicio.edit', compact('noticia'));
    }

 
    public function update(Request $request, $slug)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'archivos.*' => 'nullable|file|max:5120',
        ]);

        $noticia = Inicio::findOrFail($slug);

        // Actualizar slug solo si cambia el título
        if ($noticia->titulo !== $request->titulo) {
            $noticia->slug = Str::slug($request->titulo);
        }

        $noticia->titulo = $request->titulo;
        $noticia->descripcion = $request->descripcion;

        if ($request->hasFile('imagen')) {
            if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
                Storage::disk('public')->delete($noticia->imagen);
            }
            $noticia->imagen = $request->file('imagen')->store('inicio', 'public');
        }

        $noticia->save();


        return redirect()->route('inicio.index')->with('success', 'Noticia actualizada correctamente.');
    }

   
    public function destroy($slug)
    {
        $noticia = Inicio::with('archivos')->findOrFail($slug);

        if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
            Storage::disk('public')->delete($noticia->imagen);
        }

        foreach ($noticia->archivos as $archivo) {
            if (Storage::disk('public')->exists($archivo->archivo)) {
                Storage::disk('public')->delete($archivo->archivo);
            }
            $archivo->delete();
        }

        $noticia->delete();

        return redirect()->route('inicio.index')->with('success', 'Noticia eliminada correctamente.');
    }

    
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

    public function editImagen($slug)
    {
        $imagen = Carrusel::findOrFail($slug);
        return view('Inicio.editImagen', compact('imagen'));
    }

    public function updateImagen(Request $request, $slug)
    {
        $request->validate([
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048'
        ]);

        $imagen = Carrusel::findOrFail($slug);

        if ($request->hasFile('imagen')) {
            if ($imagen->imagen && Storage::disk('public')->exists($imagen->imagen)) {
                Storage::disk('public')->delete($imagen->imagen);
            }
            $imagen->imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $imagen->save();

        return redirect()->route('inicio.index')->with('success', 'Imagen actualizada correctamente.');
    }

    public function destroyImagen($slug)
    {
        $imagen = Carrusel::findOrFail($slug);

        if (Storage::disk('public')->exists($imagen->imagen)) {
            Storage::disk('public')->delete($imagen->imagen);
        }

        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente.');
    }
}
