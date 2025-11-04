<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuadro;

class CuadroController extends Controller
{
    // Mostrar todos los cuadros
    public function index()
    {
        $cuadros = Cuadro::all();
        return view('cuadros.index', compact('cuadros'));
    }

    // Mostrar formulario para crear
    public function crear()
    {
        return view('cuadros.crear');
    }

    // Guardar un nuevo cuadro
    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'enlace' => 'nullable|url'
        ]);

        Cuadro::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'enlace' => $request->enlace,
        ]);

        return redirect()->route('cuadros.index')->with('success', 'Cuadro agregado correctamente.');
    }

    // Mostrar formulario para editar
    public function editar(Cuadro $cuadro)
    {
        return view('cuadros.editar', compact('cuadro'));
    }

    // Actualizar cuadro
    public function actualizar(Request $request, Cuadro $cuadro)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'enlace' => 'nullable|url'
        ]);

        $cuadro->update($request->only('titulo', 'autor', 'enlace'));

        return redirect()->route('cuadros.index')->with('success', 'Cuadro actualizado correctamente.');
    }

    // Eliminar cuadro
    public function borrar(Cuadro $cuadro)
    {
        $cuadro->delete();
        return redirect()->route('cuadros.index')->with('success', 'Cuadro eliminado correctamente.');
    }
}
