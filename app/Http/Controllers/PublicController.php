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
    // 🔹 Página principal
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

    // 🔹 Mostrar una sección con sus contenidos y cuadros
    public function verSeccion($id)
    {
        $seccion = Seccion::findOrFail($id);
        $contenidos = Contenidos::where('seccion_id', $id)->get();
        $cuadros = Cuadro::where('seccion_id', $id)->get();

        $navbarSecciones = NavbarSeccion::all();
        $navbarContenidos = NavbarContenido::all();

        return view('public.seccion', compact(
            'seccion',
            'contenidos',
            'cuadros',
            'navbarSecciones',
            'navbarContenidos'
        ));
    }

    // 🔹 Mostrar un contenido específico con sus archivos
    public function verContenido($id)
    {
        $contenido = Contenidos::findOrFail($id);
        $archivos = Archivo::where('contenido_id', $id)->get();

        $navbarSecciones = NavbarSeccion::all();
        $navbarContenidos = NavbarContenido::all();

        return view('public.contenido', compact(
            'contenido',
            'archivos',
            'navbarSecciones',
            'navbarContenidos'
        ));
    }

    // 🔹 Página de videoteca pública
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
