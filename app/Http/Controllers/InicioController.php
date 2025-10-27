<?php

namespace App\Http\Controllers;

use App\Models\inicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InicioController extends Controller
{
    public function index()
    {
        $inicio = inicio::all();
        return view('Inicio.inicio', compact('inicio'));
    }

    public function create() {
    return view('Inicio.crear'); // tu formulario
}

    public function store(Request $request) {

        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('imagenes', 'public');
        }

        inicio::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $rutaImagen,
        ]);

        return redirect()->route('inicio.index')->with('success', 'Noticia creada correctamente.');
    }

    public function show($id)
    {
        $inicio = inicio::findOrFail($id);
        return view('Inicio.mostrar', compact('inicio'));
    }

    public function edit($id)
    {
        $inicio = inicio::findOrFail($id);
        return view('Inicio.editar', compact('inicio'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $inicio = inicio::findOrFail($id);

        if ($request->hasFile('imagen')) {
            if ($inicio->imagen && Storage::disk('public')->exists($inicio->imagen)) {
                Storage::disk('public')->delete($inicio->imagen);
            }

            $inicio->imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $inicio->titulo = $request->titulo;
        $inicio->descripcion = $request->descripcion;
        $inicio->save();

        return redirect()->route('inicio.index')->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $inicio = inicio::findOrFail($id);

        if ($inicio->imagen && Storage::disk('public')->exists($inicio->imagen)) {
            Storage::disk('public')->delete($inicio->imagen);
        }

        $inicio->delete();

        return redirect()->route('inicio.index')->with('success', 'Noticia eliminada correctamente.');
    }
}


