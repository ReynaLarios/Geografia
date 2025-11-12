<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Contenido;
use App\Models\Archivo;
use App\Models\Banner;
use App\Models\Carrusel;
use App\Models\Contenidos;
use App\Models\Videoteca;
use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;
use App\Models\Inicio;
use App\Models\Cuadro;

class PublicController extends Controller
{
 
    public function inicio()
    {
        $banners = Banner::all();
        $carruseles = Carrusel::all();
        $inicios = Inicio::first();
        $navbarSecciones = NavbarSeccion::all();
        $navbarContenidos = NavbarContenido::all();

        return view('public.inicio', compact(
            'banners',
            'carruseles',
            'inicios',
            'navbarSecciones',
            'navbarContenidos'
        ));
    }

    public function verSeccion($id)
    {
        $seccion = Seccion::findOrFail($id);
        $contenidos = Contenidos::where('seccion_id', $id)->get();
       

        $navbarSecciones = NavbarSeccion::all();
        $navbarContenidos = NavbarContenido::all();

        return view('public.seccion', compact(
            'seccion',
            'contenidos',

            'navbarSecciones',
            'navbarContenidos'
        ));
    }

 
    public function verContenido($id)
    {
        $contenido = Contenidos::findOrFail($id);
        

        $navbarSecciones = NavbarSeccion::all();
        $navbarContenidos = NavbarContenido::all();

        return view('public.contenido', compact(
            'contenido',
            'archivos',
            'navbarSecciones',
            'navbarContenidos'
        ));
    }

    public function videoteca()
    {
        $videos = Videoteca::all();

        $navbarSecciones = NavbarSeccion::all();
        $navbarContenidos = NavbarContenido::all();

        return view('public.videoteca', compact(
            'videos',
            'navbarSecciones',
            'navbarContenidos'
        ));
    }
}
