<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;

class PersonaController extends Controller
{
    public function index()
    {
        $personas = Persona::with('navbarContenido')->get();
        return view('personas.index', compact('personas'));
    }

    public function create()
    {
        return view('personas.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:personas,email',
            'datos_adicionales' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if($request->hasFile('foto')){
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        Persona::create($data);

        return redirect()->route('personas.index')->with('success', 'Persona creada correctamente');
    }

    public function edit(Persona $persona)
    {
        return view('personas.edit', compact('persona'));
    }

    public function update(Request $request, Persona $persona)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:personas,email,' . $persona->id,
            'datos_adicionales' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->all();

        if($request->hasFile('foto')){
            if($persona->foto){
                Storage::disk('public')->delete($persona->foto);
            }
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $persona->update($data);

        return redirect()->route('personas.index')->with('success', 'Persona actualizada correctamente');
    }

    public function destroy(Persona $persona)
    {
        if($persona->foto){
            Storage::disk('public')->delete($persona->foto);
        }

        $persona->delete();
        return redirect()->route('personas.index')->with('success', 'Persona eliminada correctamente');
    }

    public function show(Persona $persona)
    {
        return view('personas.show', compact('persona'));
    }
}
