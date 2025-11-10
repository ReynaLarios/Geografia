<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;

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

    // Guardar un nuevo cuadro con archivo
    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'archivo' => 'nullable|file|max:10240', // hasta 10MB
        ]);

        $archivoPath = null;
        $nombreReal = null;

        if($request->hasFile('archivo')){
            $archivoPath = $request->file('archivo')->store('cuadros','public');
            $nombreReal = $request->file('archivo')->getClientOriginalName();
        }

        Cuadro::create([
            'titulo' => $request->titulo,
            'autor' => $request->autor,
            'archivo' => $archivoPath,
            'nombre_real' => $nombreReal,
        ]);

        return redirect()->route('cuadros.index')->with('success', 'Cuadro agregado correctamente.');
    }

    // Mostrar formulario para editar
    public function editar(Cuadro $cuadro)
    {
        return view('cuadros.editar', compact('cuadro'));
    }

    // Actualizar cuadro con archivo
    public function actualizar(Request $request, Cuadro $cuadro)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'archivo' => 'nullable|file|max:10240',
        ]);

        $datos = $request->only('titulo', 'autor');

        if($request->hasFile('archivo')){
            // Eliminar archivo viejo si existe
            if($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)){
                Storage::disk('public')->delete($cuadro->archivo);
            }

            $archivoPath = $request->file('archivo')->store('cuadros','public');
            $nombreReal = $request->file('archivo')->getClientOriginalName();

            $datos['archivo'] = $archivoPath;
            $datos['nombre_real'] = $nombreReal;
        }

        $cuadro->update($datos);

        return redirect()->route('cuadros.index')->with('success', 'Cuadro actualizado correctamente.');
    }

    // Eliminar cuadro y su archivo
    public function borrar(Cuadro $cuadro)
    {
        if($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)){
            Storage::disk('public')->delete($cuadro->archivo);
        }

        $cuadro->delete();

        return redirect()->route('cuadros.index')->with('success', 'Cuadro eliminado correctamente.');
    }
}
