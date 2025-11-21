<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videoteca;

class VideotecaController extends Controller
{
    public function index()
    {
        $videos = Videoteca::all();
        return view('Secciones.videoteca', compact('videos'));
    }

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

    public function editar($id)
    {
        $video = Videoteca::findOrFail($id);
        return view('Secciones.editar_video', compact('video'));
    }

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

        return redirect()->route('videoteca.actualizar')->with('exito', 'Video actualizado correctamente.');
    }

    public function eliminar($id)
    {
        $video = Videoteca::findOrFail($id);
        $video->delete();

        return redirect()->route('videoteca.eliminar')->with('exito', 'Video eliminado correctamente.');
    }
}
