<?php

namespace App\Http\Controllers;

use App\Models\Noticia;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class InicioController extends Controller
{
    public function index()
    {
        $noticias = Noticia::all();
        return view('Inicio.index', compact('noticias'));
    }

    public function create()
    {
        return view('Inicio.crear');
    }

    public function store(Request $request)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $rutaImagen = null;

        if ($request->hasFile('imagen')) {
            $rutaImagen = $request->file('imagen')->store('imagenes', 'public');
        }

        Noticia::create([
            'titulo' => $request->titulo,
            'descripcion' => $request->descripcion,
            'imagen' => $rutaImagen,
        ]);

        return redirect()->route('inicio.index')->with('success', 'Noticia creada correctamente.');
    }

    public function show($id)
    {
        $noticia = Noticia::findOrFail($id);
        return view('Inicio.mostrar', compact('noticia'));
    }

    public function edit($id)
    {
        $noticia = Noticia::findOrFail($id);
        return view('Inicio.editar', compact('noticia'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'titulo' => 'required|string|max:255',
            'descripcion' => 'required|string',
            'imagen' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        $noticia = Noticia::findOrFail($id);

        if ($request->hasFile('imagen')) {
            if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
                Storage::disk('public')->delete($noticia->imagen);
            }

            $noticia->imagen = $request->file('imagen')->store('imagenes', 'public');
        }

        $noticia->titulo = $request->titulo;
        $noticia->descripcion = $request->descripcion;
        $noticia->save();

        return redirect()->route('inicio.index')->with('success', 'Noticia actualizada correctamente.');
    }

    public function destroy($id)
    {
        $noticia = Noticia::findOrFail($id);

        if ($noticia->imagen && Storage::disk('public')->exists($noticia->imagen)) {
            Storage::disk('public')->delete($noticia->imagen);
        }

        $noticia->delete();

        return redirect()->route('inicio.index')->with('success', 'Noticia eliminada correctamente.');
    }
}










MODELO
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Noticia extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'descripcion',
        'imagen',
    ];
}




MIGRACION

public function up(): void
{
    Schema::create('noticias', function (Blueprint $table) {
        $table->id();
        $table->string('titulo');
        $table->text('descripcion');
        $table->string('imagen')->nullable();
        $table->timestamps();
    });
}
