<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{

    public function index()
    {
     
        $banner = Banner::first();
        return view('banner.index', compact('banner'));
    }

 
    public function guardar(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image'
        ]);

        $banner = Banner::first();

        if (!$banner) {
            $banner = new Banner();
        }

        if ($request->hasFile('imagen')) {
  
            if ($banner->imagen && Storage::disk('public')->exists('banners/' . $banner->imagen)) {
                Storage::disk('public')->delete('banners/' . $banner->imagen);
            }


            $nombre = time() . '.' . $request->imagen->extension();
            $request->file('imagen')->storeAs('banners', $nombre, 'public');
            $banner->imagen = $nombre;
        }

        $banner->save();

        return back()->with('success', 'Banner guardado correctamente.');
    }

  
    public function borrar()
    {
        $banner = Banner::first();

        if (!$banner) {
            return back()->with('error', 'No hay banner para eliminar.');
        }

        if ($banner->imagen && Storage::disk('public')->exists('banners/' . $banner->imagen)) {
            Storage::disk('public')->delete('banners/' . $banner->imagen);
        }

        $banner->delete();

        return back()->with('success', 'Banner eliminado correctamente.');
    }
}
