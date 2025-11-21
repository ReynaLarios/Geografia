<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videoteca; // <- Importamos el modelo correcto

class VideotecaController extends Controller
{
    // ----------------------
    // ADMIN: Listado de videos
    // ----------------------
    public function index()
    {
        $videos = Videoteca::all();
        return view('Secciones.videoteca', compact('videos'));
    }

    // ----------------------
    // ADMIN: Guardar nuevo video
    // ----------------------
    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        $video = new Videoteca();
        $video->titulo = $request->titulo;
        $video->url = $request->url;
        $video->save();

        return redirect()->route('videoteca.index')->with('exito', 'Video guardado correctamente.');
    }

    // ----------------------
    // ADMIN: Editar video
    // ----------------------
    public function editar($id)
    {
        $video = Videoteca::findOrFail($id);
        return view('Secciones.editar_video', compact('video'));
    }

    // ----------------------
    // ADMIN: Actualizar video
    // ----------------------
    public function actualizar(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        $video = Videoteca::findOrFail($id);
        $video->titulo = $request->titulo;
        $video->url = $request->url;
        $video->save();

        return redirect()->route('videoteca.index')->with('exito', 'Video actualizado correctamente.');
    }

    // ----------------------
    // ADMIN: Eliminar video
    // ----------------------
    public function eliminar($id)
    {
        $video = Videoteca::findOrFail($id);
        $video->delete();

        return redirect()->route('videoteca.index')->with('exito', 'Video eliminado correctamente.');
    }

    // ----------------------
    // PÚBLICO: Ver solo videos visibles
    // ----------------------
    // ----------------------
    public function publicIndex()
    {
        // Traemos todos los videos de la tabla videotecas
        $videos = Videoteca::all();

        return view('public.videoteca', compact('videos'));
    }
}

