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
use App\Models\Persona;

class PublicController extends Controller
{
    
    public function inicio()
    {
        $imagenesCarrusel = Carrusel::all();
        $noticias = Inicio::orderBy('created_at', 'desc')->get();
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.inicios.index', compact('imagenesCarrusel', 'noticias', 'secciones'));
    }
public function inicioShow($slug)
{
    $inicio = Inicio::where('slug', $slug)->firstOrFail();
    $secciones = Seccion::where('oculto_publico', false)->get();
    return view('public.inicios.show', compact('inicio', 'secciones'));
}

    public function carrusel()
    {
        $imagenesCarrusel = Carrusel::all();
        $noticias = Inicio::with('archivos')->get();

        return view('public.inicio', compact('imagenesCarrusel', 'noticias'));
    }

    public function historial()
{
    $noticias = Inicio::orderBy('created_at', 'desc')->paginate(5); 
    return view('public.historial', compact('noticias'));
}


    
    public function navbarSeccionesIndex()
    {
        $secciones = NavbarSeccion::with('contenidos')->get();
        return view('public.navbar_secciones.index', compact('secciones'));
    }

    public function navbarSeccionesShow($slug)
{
    $seccion = NavbarSeccion::with(['contenidosNavbar'])->where('slug', $slug)->firstOrFail();
    return view('public.navbar_secciones.show', compact('seccion'));
}


    public function navbarContenidosIndex()
    {
        $navbarContenidos = NavbarContenido::with('seccion','cuadros.archivos')->get();
        return view('public.navbar_contenidos.index', compact('navbarContenidos'));
    }

  public function navbarContenidoShow($slug)
{
    $contenido = NavbarContenido::with(['cuadros', 'archivos'])->where('slug', $slug)->firstOrFail();
    return view('public.navbar_contenidos.show', compact('contenido'));
}

    
    public function seccionesIndex()
    {
        $secciones = Seccion::with(['cuadros.archivos','contenidos'])->where('oculto_publico', false)->get();
        return view('public.secciones.index', compact('secciones'));
    }

    public function seccionesShow($slug)
    {
        $seccion = Seccion::with(['archivos','cuadros.archivos'])->where('slug',$slug)->firstOrFail();
        $secciones = Seccion::where('oculto_publico', false)->get();
        return view('public.secciones.show', compact('seccion','secciones'));
    }

    
    public function contenidosIndex()
    {
        $contenidos = Contenidos::with(['seccion','cuadros.archivos'])->get();
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.contenidos.index', compact('contenidos','secciones'));
    }

    public function contenidosShow($slug)
{
    $contenido = Contenidos::with(['seccion','cuadros'])->where('slug', $slug)->firstOrFail();
    $secciones = Seccion::where('oculto_publico', false)->get();

    return view('public.contenidos.show', compact('contenido', 'secciones'));
}


   
    public function cuadrosIndex()
    {
        $cuadros = Cuadro::with('archivos')->get();
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.cuadros.index', compact('cuadros','secciones'));
    }

    
    public function videotecaIndex()
    {
        $videos = Videoteca::orderBy('created_at','desc')->get();
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.videoteca.index', compact('videos','secciones'));
    }

    
 public function personasIndex()
    {
        
        $personas = Persona::all();

        
        $secciones = Seccion::where('oculto_publico', false)->get();

        return view('public.personas.index', compact('personas', 'secciones'));
    }

   
   public function personasShow($slug)
{
    $persona = Persona::where('slug', $slug)->firstOrFail();
    $secciones = Seccion::where('oculto_publico', false)->get();

    return view('public.personas.show', compact('persona','secciones'));
}


 
    public function personasAutocomplete(Request $request)
    {
        $q = $request->input('q');

        
        if (!$q || strlen($q) < 2) {
            return response()->json([]);
        }

        
        $personas = Persona::where('nombre', 'like', $q . '%')
                            ->take(10)
                            ->get(['nombre', 'slug']);

        
        $result = $personas->map(function ($p) {
            return [
                'nombre' => $p->nombre,
                'url' => route('public.personas.show', $p->slug)
            ];
        });

        return response()->json($result);
    }
}

