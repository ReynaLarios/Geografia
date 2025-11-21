<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Persona;
use Illuminate\Support\Facades\Storage;

class PersonaController extends Controller
{
    // LISTADO
public function index()
{
    // Paginación de 12 personas por página
    $personas = Persona::paginate(12);
    return view('personas.index', compact('personas'));
}


    // FORMULARIO CREAR
    public function crear()
    {
        return view('personas.crear');
    }

    // GUARDAR
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

    Persona::create($data);

    return redirect()->route('personas.index')->with('success', 'Persona creada correctamente');
}

    // FORMULARIO EDITAR
    public function editar(Persona $persona)
    {
        return view('personas.editar', compact('persona'));
    }

    // ACTUALIZAR
    public function actualizar(Request $request, Persona $persona)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'email' => 'required|email|unique:personas,email,' . $persona->id,
            'datos_personales' => 'nullable|string',
            'foto' => 'nullable|image|max:2048',
        ]);

        $data = $request->except('foto');

        if($request->hasFile('foto')){
            if($persona->foto){
                Storage::disk('public')->delete($persona->foto);
            }
            $data['foto'] = $request->file('foto')->store('fotos', 'public');
        }

        $persona->update($data);

        return redirect()->route('personas.index')->with('success', 'Persona actualizada correctamente');
    }

    // BORRAR
    public function borrar(Persona $persona)
    {
        if($persona->foto){
            Storage::disk('public')->delete($persona->foto);
        }

        $persona->delete();

        return redirect()->route('personas.index')->with('success', 'Persona eliminada correctamente');
    }

    // MOSTRAR INFORMACIÓN INDIVIDUAL
    public function mostrar(Persona $persona)
    {
        return view('personas.mostrar', compact('persona'));
    }

// PersonaController.php

// LISTADO PÚBLICO
// LISTADO PÚBLICO
public function publicIndex()
{
    $personas = Persona::paginate(12); // Importante: usar paginate para que la paginación funcione
    return view('public.personas.index', compact('personas'));
}

public function publicShow(Persona $persona)
{
    return view('public.personas.show', compact('persona'));
}
}
