MIIIGRACIOOON 
<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('videos', function (Blueprint $table) {
            $table->id();
            $table->string('titulo');
            $table->string('url');
            $table->string('categoria')->nullable();
            $table->string('anio')->nullable();
            $table->text('descripcion')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('videos');
    }
};



MODELOOOOOOOOOOOOOOOOOOO
<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Video extends Model
{
    use HasFactory;

    protected $fillable = [
        'titulo',
        'url',
        'categoria',
        'anio',
        'descripcion',
    ];
}


controladooooor 

public function store(Request $request)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'url' => 'required|url',
    ]);

    $data = $request->all();
    $data['url'] = $this->convertToEmbed($request->url);

    Video::create($data);
    return redirect()->route('videoteca.index')->with('success', 'Video agregado correctamente.');
}

public function update(Request $request, $id)
{
    $request->validate([
        'titulo' => 'required|string|max:255',
        'url' => 'required|url',
    ]);

    $video = Video::findOrFail($id);
    $data = $request->all();
    $data['url'] = $this->convertToEmbed($request->url);

    $video->update($data);
    return redirect()->route('videoteca.index')->with('success', 'Video actualizado correctamente.');
}

/**
 * Convierte enlaces normales de YouTube a formato embed
 */
private function convertToEmbed($url)
{
    // Si viene en formato corto (youtu.be)
    if (preg_match('/youtu\.be\/([^\?]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    // Si viene en formato largo (youtube.com/watch?v=)
    if (preg_match('/v=([^\&]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    // Si ya está en formato embed o algo distinto, lo dejamos igual
    return $url;
}
