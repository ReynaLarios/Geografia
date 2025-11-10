<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;

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

        $nombre = time() . '.' . $request->imagen->extension();
        $request->imagen->move(public_path('banners'), $nombre);

        $banner = Banner::first() ?? new Banner();
        $banner->imagen = $nombre;
        $banner->save();

        return back()->with('success', 'Banner guardado correctamente.');
    }

    public function editar()
    {
        $banner = Banner::first();
        return view('banner.editar', compact('banner'));
    }

    public function actualizar(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image'
        ]);

        $banner = Banner::first();

 
        if ($banner && $banner->imagen && file_exists(public_path('banners/' . $banner->imagen))) {
            unlink(public_path('banners/' . $banner->imagen));
        }

     
        $nombre = time() . '.' . $request->imagen->extension();
        $request->imagen->move(public_path('banners'), $nombre);

        $banner->imagen = $nombre;
        $banner->save();

        return back()->with('success', 'Banner actualizado correctamente.');
    }

    public function borrar()


    {
        $banner = Banner::first();

        if ($banner && $banner->imagen && file_exists(public_path('banners/' . $banner->imagen))) {
            unlink(public_path('banners/' . $banner->imagen));
        }

        $banner->delete();

        return back()->with('success', 'Banner eliminado.');
    }
}
