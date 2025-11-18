<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Inicio;
use App\Models\NavbarSeccion;
use App\Models\NavbarContenido;
use App\Models\Seccion;
use App\Models\Contenidos;
use App\Models\Cuadro;
use App\Models\Videoteca;

class PublicController extends Controller
{
    // Página principal (inicio) — carrusel y noticias
    public function inicio()
    {
        $imagenes = Inicio::orderBy('id', 'desc')->get(); // Carrusel / imágenes
        $noticias = Inicio::whereNotNull('titulo')->orderBy('created_at', 'desc')->get(); // Noticias
        return view('public.inicios.index', compact('imagenes', 'noticias'));
    }

    // Carrusel independiente
    public function carrusel()
    {
        $imagenes = Inicio::orderBy('id', 'desc')->get();
        return view('public.inicios.index', compact('imagenes'));
    }

    // NAVBAR - secciones (listado)
    public function navbarSeccionesIndex()
    {
        $secciones = NavbarSeccion::with('contenidosNavbar')->get();
        return view('public.navbar_secciones.index', compact('secciones'));
    }

    // NAVBAR - mostrar sección individual
    public function navbarSeccionesMostrar($id)
    {
        $seccion = NavbarSeccion::with('contenidosNavbar')->findOrFail($id);
        return view('public.navbar_secciones.show', compact('seccion'));
    }

    // NAVBAR - contenidos (listado)
    public function navbarContenidosIndex()
    {
        $navbarContenidos = NavbarContenido::with('seccion')->get();
        return view('public.navbar_contenidos.index', compact('navbarContenidos'));
    }

    // NAVBAR - mostrar contenido individual
    public function navbarContenidoMostrar($id)
    {
        $contenido = NavbarContenido::with(['seccion','cuadros'])->findOrFail($id);
        return view('public.navbar_contenidos.show', compact('contenido'));
    }

    // Secciones públicas (página con secciones normales)
    public function seccionesIndex()
    {
        $secciones = Seccion::with(['cuadros','contenidos'])->get();
        return view('public.secciones.index', compact('secciones'));
    }

    // Mostrar sección normal
    public function seccionesMostrar($id)
    {
        $seccion = Seccion::with(['cuadros','contenidos'])->findOrFail($id);
        return view('public.secciones.show', compact('seccion'));
    }

    // Contenidos públicos (listado)
    public function contenidosIndex()
    {
        $contenidos = Contenidos::with('seccion','cuadros')->get();
        return view('public.contenidos.show', compact('contenidos'));
    }

    // Mostrar contenido individual
    public function contenidosMostrar($id)
    {
        $contenido = Contenidos::with(['seccion','cuadros'])->findOrFail($id);
        return view('public.contenidos.show', compact('contenido'));
    }

    // Cuadros (solo mostrar)
    public function cuadrosIndex()
    {
        $cuadros = Cuadro::all();
        return view('public.cuadros.index', compact('cuadros'));
    }

    // Videoteca
    public function videotecaIndex()
    {
        $videos = Videoteca::orderBy('created_at','desc')->get();
        return view('public.videoteca.index', compact('videos'));
    }
}
