<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function actualizar(Request $request)
    {
        $request->validate([
            'imagen' => 'required|image|mimes:jpg,jpeg,png,gif|max:4096',
        ]);

        $banner = Banner::latest()->first();

        if($banner){
            // Borrar imagen antigua si existe
            if(Storage::exists('public/'.$banner->imagen)){
                Storage::delete('public/'.$banner->imagen);
            }
        } else {
            $banner = new Banner();
        }

        // Guardar nueva imagen
        $ruta = $request->file('imagen')->store('banners', 'public');
        $banner->imagen = $ruta;
        $banner->save();

        return back()->with('success', 'Banner actualizado correctamente.');
    }
}
