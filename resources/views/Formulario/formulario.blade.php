php artisan make:model Persona


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'navbar_contenido_id',
        'nombre',
        'email',
        'telefono',
        'datos_adicionales',
        'foto',
    ];

    public function navbarContenido()
    {
        return $this->belongsTo(NavbarContenido::class);
    }
}





php artisan make:controller PersonaController
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



migration 

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    use HasFactory;

    protected $fillable = [
        'navbar_contenido_id',
        'nombre',
        'email',
        'datos_adicionales',
        'foto',
    ];

    public function navbarContenido()
    {
        return $this->belongsTo(NavbarContenido::class);
    }
}


RUTAS 

use App\Http\Controllers\PersonaController;

Route::prefix('personas')->name('personas.')->group(function () {
    Route::get('/', [PersonaController::class, 'index'])->name('index');
    Route::get('/crear', [PersonaController::class, 'create'])->name('create');
    Route::post('/crear', [PersonaController::class, 'store'])->name('store');
    Route::get('/{persona}/editar', [PersonaController::class, 'edit'])->name('edit');
    Route::put('/{persona}', [PersonaController::class, 'update'])->name('update');
    Route::delete('/{persona}', [PersonaController::class, 'destroy'])->name('destroy');
    Route::get('/{persona}', [PersonaController::class, 'show'])->name('show');
});



index

@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Listado de Personas</h2>
    <a href="{{ route('personas.create') }}" class="btn btn-primary mb-3">Crear Persona</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nombre</th>
                <th>Email</th>
                <th>Datos Adicionales</th>
                <th>Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($personas as $persona)
            <tr>
                <td>
                    @if($persona->foto)
                        <img src="{{ asset('storage/' . $persona->foto) }}" width="50">
                    @endif
                </td>
                <td>{{ $persona->nombre }}</td>
                <td>{{ $persona->email }}</td>
                <td>{{ $persona->datos_adicionales }}</td>
                <td>
                    <a href="{{ route('personas.show', $persona->id) }}" class="btn btn-info btn-sm">Ver</a>
                    <a href="{{ route('personas.edit', $persona->id) }}" class="btn btn-warning btn-sm">Editar</a>
                    <form action="{{ route('personas.destroy', $persona->id) }}" method="POST" style="display:inline-block">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm"
                        onclick="return confirm('¿Seguro que quieres eliminar esta persona?')">Eliminar</button>
                    </form>
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection



Crear

@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Crear Persona</h2>
    <form action="{{ route('personas.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre') }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email') }}">
        </div>
        <div class="mb-3">
            <label>Datos Adicionales</label>
            <textarea name="datos_adicionales" class="form-control">{{ old('datos_adicionales') }}</textarea>
        </div>
        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
        </div>
        <button type="submit" class="btn btn-success">Guardar</button>
        <a href="{{ route('personas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection


Editar
@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Editar Persona</h2>
    <form action="{{ route('personas.update', $persona->id) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="nombre" class="form-control" value="{{ old('nombre', $persona->nombre) }}">
        </div>
        <div class="mb-3">
            <label>Email</label>
            <input type="email" name="email" class="form-control" value="{{ old('email', $persona->email) }}">
        </div>
        <div class="mb-3">
            <label>Datos Adicionales</label>
            <textarea name="datos_adicionales" class="form-control">{{ old('datos_adicionales', $persona->datos_adicionales) }}</textarea>
        </div>
        <div class="mb-3">
            <label>Foto</label>
            <input type="file" name="foto" class="form-control">
            @if($persona->foto)
                <img src="{{ asset('storage/' . $persona->foto) }}" width="100" class="mt-2">
            @endif
        </div>
        <button type="submit" class="btn btn-success">Actualizar</button>
        <a href="{{ route('personas.index') }}" class="btn btn-secondary">Cancelar</a>
    </form>
</div>
@endsection


mostrar

@extends('base.layout')

@section('contenido')
<div class="container mt-4">
    <h2>Detalles de Persona</h2>
    <div class="card p-3">
        @if($persona->foto)
            <img src="{{ asset('storage/' . $persona->foto) }}" width="150" class="mb-3">
        @endif
        <p><strong>Nombre:</strong> {{ $persona->nombre }}</p>
        <p><strong>Email:</strong> {{ $persona->email }}</p>
        <p><strong>Datos Adicionales:</strong> {{ $persona->datos_adicionales }}</p>
        <a href="{{ route('personas.index') }}" class="btn btn-secondary">Volver</a>
    </div>
</div>
@endsection


