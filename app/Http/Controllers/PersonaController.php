<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class PersonaController extends Controller
{
    
    public function index()
    {
        $personas = Persona::paginate(12);
        return view('personas.index', compact('personas'));
    }

    public function crear()
    {
        return view('personas.crear');
    }

    public function guardar(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:personas,email',
            'datos_personales' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->only(['nombre', 'email', 'datos_personales']);

        if ($request->hasFile('foto')) {
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        
        $data['slug'] = Str::slug($request->nombre, '-');

        Persona::create($data);

        return redirect()->route('personas.index')->with('success', 'Persona creada correctamente');
    }

    
        public function editar($slug)
{
    $persona = Persona::where('slug', $slug)
                          ->firstOrFail();
        return view('personas.editar', compact('persona'));
    }

  public function actualizar(Request $request, $slug)
{
    $persona = Persona::where('slug', $slug)->firstOrFail();

    $request->validate([
        'nombre' => 'required|string|max:255',
        'email' => 'required|email|unique:personas,email,' . $persona->id,
        'datos_personales' => 'nullable|string',
        'foto' => 'nullable|image|max:2048',
    ]);

    $data = $request->except('foto');

    if ($request->hasFile('foto')) {
        
        if ($persona->foto) {
            Storage::disk('public')->delete($persona->foto);
        }
        $data['foto'] = $request->file('foto')->store('fotos', 'public');
    }

    $data['slug'] = Str::slug($request->nombre, '-');

    $persona->update($data);

    return redirect()->route('personas.index')->with('success', 'Persona actualizada correctamente');
}

    public function borrar($slug)  {
    $persona = Persona::where('slug', $slug)->firstOrFail();
  
    {
        if ($persona->foto) {
            Storage::disk('public')->delete($persona->foto);
        }

        $persona->delete();

        return redirect()->route('personas.index')->with('success', 'Persona eliminada correctamente');
    }
}
    
     public function mostrar($slug) {
    $persona = Persona::where('slug', $slug)->firstOrFail();

        return view('personas.mostrar', compact('persona'));
    }
   
    public function publicIndex()
    {
        $personas = Persona::paginate(12);
        return view('public.personas.index', compact('personas'));
    }

   
    public function publicShow($slug)
    {
        $persona = Persona::where('slug', $slug)->firstOrFail();
        return view('public.personas.show', compact('persona'));
    }

    
    public function autocomplete(Request $request)
    {
        $q = $request->input('q');

        
        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        $personas = Persona::where('nombre', 'like', $q . '%')
                            ->take(10)
                            ->get(['nombre', 'slug']);

        $result = $personas->map(function ($p) {
            return [
                'nombre' => $p->nombre,
                'url' => route('public.personas.show', $p->slug)
            ];
        });

        return response()->json($result);
    }
}
