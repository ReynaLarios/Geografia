<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Videoteca;

class VideotecaController extends Controller

{
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
private function convertToEmbed($url)
{
    if (preg_match('/youtu\.be\/([^\?]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    if (preg_match('/v=([^\&]+)/', $url, $matches)) {
        return 'https://www.youtube.com/embed/' . $matches[1];
    }

    return $url;
}

}
