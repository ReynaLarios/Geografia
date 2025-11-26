<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Seccion;
use App\Models\Contenidos;
use App\Models\Cuadro;
use App\Models\Videoteca;
use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;
use App\Models\Inicio;
use App\Models\Carrusel;

class PublicController extends Controller
{
   
public function inicio()
{
    $imagenesCarrusel = Carrusel::all();  
    $noticias = Inicio::orderBy('created_at', 'desc')->get();
    $secciones = Seccion::where('oculto_publico', false)->get();

    return view('public.inicios.index', compact('imagenesCarrusel', 'noticias', 'secciones'));
}


    public function inicioShow($id)
    {
        $noticia = Inicio::findOrFail($id);
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.inicios.show', compact('noticia', 'secciones'));
    }

   
    public function carrusel()
    {
       $imagenesCarrusel = Carrusel::all();
$noticias = Inicio::with('archivos')->get();

return view('public.inicio', compact('imagenesCarrusel', 'noticias'));

    }


  
    public function navbarSeccionesIndex()
    {
        $secciones = NavbarSeccion::with('contenidosNavbar')->get();

        return view('public.navbar_secciones.index', compact('secciones'));
    }

    public function navbarSeccionesMostrar($id)
    {
        $seccion = NavbarSeccion::with('contenidosNavbar')->findOrFail($id);

        return view('public.navbar_secciones.show', compact('seccion'));
    }

    public function navbarContenidosIndex()
    {
        $navbarContenidos = NavbarContenido::with('seccion')->get();

        return view('public.navbar_contenidos.index', compact('navbarContenidos'));
    }

    public function navbarContenidoMostrar($id)
    {
        $contenido = NavbarContenido::with(['seccion','cuadros'])->findOrFail($id);

        return view('public.navbar_contenidos.show', compact('contenido'));
    }

    public function seccionesIndex()
    {
        $secciones = Seccion::with(['cuadros','contenidos'])
            ->where('oculto_publico', false)
            ->get();

        return view('public.secciones.index', compact('secciones'));
    }

    public function seccionesMostrar($slug)
    {
       $seccion = Seccion::with(['archivos', 'cuadros.archivos'])->where('slug',$slug)->first();

        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.secciones.show', compact('seccion', 'secciones'));
    }

  
    public function contenidosIndex()
    {
        $contenidos = Contenidos::with('seccion','cuadros')->get();
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.contenidos.index', compact('contenidos', 'secciones'));
    }

    public function contenidosMostrar($id)
    {
        $contenido = Contenidos::with(['seccion','cuadros'])->findOrFail($id);
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.contenidos.show', compact('contenido', 'secciones'));
    }


    public function cuadrosIndex()
    {
        $cuadros = Cuadro::all();
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.cuadros.index', compact('cuadros', 'secciones'));
    }

    public function videotecaIndex()
    {
        $videos = Videoteca::orderBy('created_at','desc')->get();
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.videoteca.index', compact('videos', 'secciones'));
    }
}
