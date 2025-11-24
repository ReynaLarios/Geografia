<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Cuadro;
use Illuminate\Support\Facades\Storage;

class CuadroController extends Controller
{
    public function index(Request $request)
    {
     
        $cuadros = Cuadro::orderBy('titulo', 'asc');

        if ($request->has('letra') && $request->letra != '') {
            $letra = $request->letra;
            $cuadros = $cuadros->where('titulo', 'like', $letra . '%');
        }

        $cuadros = $cuadros->get();

        return view('cuadros.index', compact('cuadros'));
    }

    public function crear()
    {
        return view('cuadros.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'archivo' => 'nullable|file|max:10240',
        ]);

        $archivoPath = null;
        $nombreReal = null;

        if ($request->hasFile('archivo')) {
            $archivoPath = $request->file('archivo')->store('cuadros', 'public');
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

    public function editar(Cuadro $cuadro)
    {
        return view('cuadros.editar', compact('cuadro'));
    }

    public function actualizar(Request $request, Cuadro $cuadro)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'autor' => 'nullable|string|max:255',
            'archivo' => 'nullable|file|max:10240',
        ]);

        $datos = [
            'titulo' => $request->titulo,
            'autor' => $request->autor,
        ];

        if ($request->hasFile('archivo')) {
            if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
                Storage::disk('public')->delete($cuadro->archivo);
            }

            $archivoPath = $request->file('archivo')->store('cuadros', 'public');
            $nombreReal = $request->file('archivo')->getClientOriginalName();

            $datos['archivo'] = $archivoPath;
            $datos['nombre_real'] = $nombreReal;
        }

        $cuadro->update($datos);

        return redirect()->route('cuadros.index')->with('success', 'Cuadro actualizado correctamente.');
    }

    public function borrar(Cuadro $cuadro)
    {
        if ($cuadro->archivo && Storage::disk('public')->exists($cuadro->archivo)) {
            Storage::disk('public')->delete($cuadro->archivo);
        }

        $cuadro->delete();

        return redirect()->route('cuadros.index')->with('success', 'Cuadro eliminado correctamente.');
    }
}
