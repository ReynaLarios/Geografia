<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeccionesController;
use App\Http\Controllers\ContenidosController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\Administrador\AdministradorController;
use App\Http\Controllers\Administrador\LoginController;
use App\Http\Controllers\CuadroController;
use App\Http\Controllers\VideotecaController;
use App\Http\Controllers\NavbarSeccionesController;
use App\Http\Controllers\NavbarContenidosController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\VisibilityController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\BuscadorController;
use App\Http\Controllers\AuthController;





    // PÁGINA PRINCIPAL
Route::get('/', [PublicController::class, 'inicio'])->name('public.inicio.index');
Route::get('/inicio/{slug}', [PublicController::class, 'inicioShow'])->name('public.inicios.show');
 Route::get('public/historial', [PublicController::class, 'historial'])->name('public.inicio.historial');
//RUTAS PÚBLICAS 

// PERSONAS
Route::get('/academico', [PersonaController::class, 'publicIndex'])->name('public.personas.index');
Route::get('/academico/{slug}', [PersonaController::class, 'publicShow'])->name('public.personas.show');

// CARRUSEL
Route::get('/carrusel', [PublicController::class, 'carrusel'])->name('public.carrusel');

// NAVBAR
Route::get('/navbar/seccion', [PublicController::class, 'navbarSeccionesIndex'])->name('public.navbar.secciones.index');
Route::get('/navbar/seccion/{slug}', [PublicController::class, 'navbarSeccionesshow'])->name('public.navbar.secciones.show');
Route::get('/navbar/contenido', [PublicController::class, 'navbarContenidosIndex'])->name('public.navbar.contenidos.index');
Route::get('/navbar/contenido/{slug}', [PublicController::class, 'navbarContenidoshow'])->name('public.navbar.contenido.show');

// SECCIONES PÚBLICAS
Route::get('/seccion', [PublicController::class, 'seccionesIndex'])->name('public.secciones.index');
Route::get('/seccion/{slug}', [PublicController::class, 'seccionesshow'])->name('public.secciones.show');

// CONTENIDOS PÚBLICOS
Route::get('/contenido/public', [PublicController::class, 'contenidosIndex'])->name('public.contenidos.index');
Route::get('/contenido/{slug}', [PublicController::class, 'contenidosshow'])->name('public.contenidos.show');

// CUADROS
Route::get('/cuadros', [PublicController::class, 'cuadrosIndex'])->name('public.cuadros.index');

// VIDEOTECA
Route::get('/videoteca', [VideotecaController::class, 'publicIndex'])->name('videoteca');

// BUSCADOR
Route::get('/buscador/autocomplete', [BuscadorController::class, 'autocomplete'])->name('buscador.autocomplete');
Route::get('/buscador/resultados', [BuscadorController::class, 'resultados'])->name('buscador.resultados');


//LOGIN 
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); 

//RUTAS ADMINISTRADOR (protegidas por middleware admin)

Route::middleware(['admin'])->group(function () {


    // DASHBOARD
    Route::get('/dashboard', [InicioController::class, 'index'])->name('dashboard');

    // ADMINISTRADORES
    Route::prefix('administrador')->group(function () {
        Route::get('/listado', [AdministradorController::class, 'listado'])->name('administrador.listado');
        Route::put('/guardar', [AdministradorController::class, 'guardar'])->name('administrador.guardar');
        Route::get('/editar/{slug}', [AdministradorController::class, 'editar'])->name('administrador.editar');
        Route::put('/actualizar/{slug}', [AdministradorController::class, 'actualizar'])->name('administrador.actualizar');
        Route::get('/mostrar/{slug}', [AdministradorController::class, 'mostrar'])->name('administrador.mostrar');
        Route::delete('/eliminar/{slug}', [AdministradorController::class, 'eliminar'])->name('administrador.eliminar');
    });

    //Historial
    Route::prefix('admin/inicio')->middleware('admin')->group(function () {
          Route::get('/historial', [InicioController::class, 'historial'])->name('inicio.historial');
    Route::delete('/noticias/{slug}', [InicioController::class, 'destroy'])->name('noticias.destroy');

          
    // PAGINA DE INICIO (admin)
        Route::prefix('inicio')->group(function () {
        Route::get('/', [InicioController::class, 'index'])->name('inicio.index');
        Route::get('/admin/create', [InicioController::class, 'create'])->name('admin.inicio.create');
        Route::post('/store', [InicioController::class, 'store'])->name('inicio.store');
        Route::get('/show/{slug}', [InicioController::class, 'show'])->name('inicio.show');
        Route::get('/editar/{slug}', [InicioController::class, 'edit'])->name('inicio.edit');
        Route::put('/update/{slug}', [InicioController::class, 'update'])->name('inicio.update');
        Route::delete('/{slug}', [InicioController::class, 'destroy'])->name('inicio.destroy');
   

        // CARRUSEL
        Route::get('/carrusel/create', [InicioController::class, 'createImagen'])->name('inicio.createImagen');
        Route::post('/carrusel/store', [InicioController::class, 'storeImagen'])->name('inicio.storeImagen');
        Route::get('/carrusel/{slug}/edit', [InicioController::class, 'editImagen'])->name('inicio.editImagen');
        Route::put('/carrusel/{slug}', [InicioController::class, 'updateImagen'])->name('inicio.updateImagen');
        Route::delete('/carrusel/{slug}', [InicioController::class, 'destroyImagen'])->name('inicio.destroyImagen');


        Route::delete('/{slug}/imagen/{campo}', [InicioController::class, 'borrarImagen'])->name('inicio.borrarImagen');
    });

    // NAVBAR SECCIONES
    Route::prefix('navbar/secciones')->group(function () {
        Route::get('/panel', [NavbarSeccionesController::class, 'panel'])->name('navbar.secciones.panel');
        Route::get('/index', [NavbarSeccionesController::class, 'index'])->name('navbar.secciones.index');
        Route::get('/crear', [NavbarSeccionesController::class, 'crear'])->name('navbar.secciones.crear');
        Route::post('/guardar', [NavbarSeccionesController::class, 'guardar'])->name('navbar.secciones.guardar');
        Route::get('/{slug}', [NavbarSeccionesController::class, 'mostrar'])->name('navbar.secciones.mostrar');
        Route::get('/{slug}/editar', [NavbarSeccionesController::class, 'editar'])->name('navbar.secciones.editar');
        Route::put('/{slug}/actualizar', [NavbarSeccionesController::class, 'actualizar'])->name('navbar.secciones.actualizar');
        Route::delete('/{slug}/borrar', [NavbarSeccionesController::class, 'borrar'])->name('navbar.secciones.borrar');
        Route::post('/{slug}/cuadro/guardar', [NavbarSeccionesController::class, 'guardarCuadro'])->name('navbar.secciones.guardarCuadro');
        Route::delete('/{slug}/cuadro/eliminar', [NavbarSeccionesController::class, 'eliminarCuadro'])->name('navbar.secciones.eliminarCuadro');
        Route::get('/borrarArchivo/{archivoId}', [NavbarSeccionesController::class, 'borrarArchivo'])->name('navbar.secciones.borrarArchivo');
         Route::get('/borrarImagen/{id}', [NavbarSeccionesController::class, 'borrarImagen'])->name('navbar.secciones.borrarImagen');
});
  

    // NAVBAR CONTENIDOS
    Route::prefix('navbar/contenidos')->group(function () {
        Route::get('/index', [NavbarContenidosController::class, 'index'])->name('navbar.contenidos.index');
        Route::get('/crear', [NavbarContenidosController::class, 'crear'])->name('navbar.contenidos.crear');
        Route::post('/guardar', [NavbarContenidosController::class, 'guardar'])->name('navbar.contenidos.guardar');
        Route::get('/{slug}', [NavbarContenidosController::class, 'mostrar'])->name('navbar.contenidos.mostrar');
        Route::get('/{slug}/editar', [NavbarContenidosController::class, 'editar'])->name('navbar.contenidos.editar');
        Route::put('/{slug}/actualizar', [NavbarContenidosController::class, 'actualizar'])->name('navbar.contenidos.actualizar');
        Route::delete('/{slug}/borrar', [NavbarContenidosController::class, 'borrar'])->name('navbar.contenidos.borrar');
    });

    // SECCIONES ADMIN
    Route::prefix('secciones')->group(function () {
        Route::get('/listado', [SeccionesController::class, 'listado'])->name('secciones.listado');
        Route::get('/crear', [SeccionesController::class, 'crear'])->name('secciones.crear');
        Route::post('/guardar', [SeccionesController::class, 'guardar'])->name('secciones.guardar');
        Route::get('/{slug}/editar', [SeccionesController::class, 'editar'])->name('secciones.editar');
        Route::put('/{slug}/actualizar', [SeccionesController::class, 'actualizar'])->name('secciones.actualizar');
        Route::post('/{slug}/cuadro/guardar', [SeccionesController::class, 'guardarCuadro'])->name('secciones.cuadro.guardar');
        Route::delete('/cuadros/{slug}/borrar', [SeccionesController::class, 'eliminarCuadro'])->name('cuadros.borrar');
        Route::post('/{slug}/archivo', [SeccionesController::class, 'guardarArchivo'])->name('secciones.archivo.guardar');
        Route::delete('/archivos/{slug}/borrar', [SeccionesController::class, 'eliminarArchivo'])->name('archivos.borrar');
        Route::get('/{slug}', [SeccionesController::class, 'mostrar'])->name('secciones.mostrar');
        Route::delete('/{slug}/borrar', [SeccionesController::class, 'borrar'])->name('secciones.borrar');
    });

    // VIDEOTECA ADMIN
    Route::prefix('videoteca')->group(function () {
        Route::get('/index', [VideotecaController::class, 'index'])->name('videoteca.index');
        Route::post('/guardar', [VideotecaController::class, 'guardar'])->name('videoteca.guardar');
        Route::get('/editar/{slug}', [VideotecaController::class, 'editar'])->name('videoteca.editar');
        Route::put('/actualizar/{slug}', [VideotecaController::class, 'actualizar'])->name('videoteca.actualizar');
        Route::delete('/eliminar/{slug}', [VideotecaController::class, 'eliminar'])->name('videoteca.eliminar');
    });

    // CONTENIDOS ADMIN
    Route::prefix('contenidos')->group(function () {
        Route::get('/listado', [ContenidosController::class, 'listado'])->name('contenidos.listado');
        Route::get('/crear', [ContenidosController::class, 'crear'])->name('contenidos.crear');
        Route::post('/guardar', [ContenidosController::class, 'guardar'])->name('contenidos.guardar');
        Route::get('/{slug}/editar', [ContenidosController::class, 'editar'])->name('contenidos.editar');
        Route::put('/{slug}/actualizar', [ContenidosController::class, 'actualizar'])->name('contenidos.actualizar');
        Route::get('/{slug}/mostrar', [ContenidosController::class, 'mostrar'])->name('contenidos.mostrar');
        Route::delete('/{slug}/borrar', [ContenidosController::class, 'borrar'])->name('contenidos.borrar');
    });

    // ARCHIVOS ADMIN
    Route::prefix('archivos')->group(function () {
        Route::get('/{contenido_slug}/listar', [ArchivoController::class, 'listar'])->name('archivos.listar');
        Route::get('/{contenido_slug}/crear', [ArchivoController::class, 'crear'])->name('archivos.crear');
        Route::put('/{contenido_slug}/guardar', [ArchivoController::class, 'guardar'])->name('archivos.guardar');
        Route::delete('/{slug}/borrar', [ArchivoController::class, 'borrar'])->name('archivos.borrar');
        Route::get('/{slug}/descargar', [ArchivoController::class, 'descargar'])->name('archivos.descargar');
    });

    // BANNERS ADMIN
    Route::prefix('banners')->group(function () {
        Route::get('/index', [BannerController::class, 'index'])->name('banner.index');
        Route::get('/editar', [BannerController::class, 'editar'])->name('banner.editar');
        Route::post('/actualizar', [BannerController::class, 'actualizar'])->name('banner.actualizar');
        Route::post('/guardar', [BannerController::class, 'guardar'])->name('banner.guardar');
        Route::delete('/borrar', [BannerController::class, 'borrar'])->name('banner.borrar');
    });

    // PERSONAS ADMIN
    Route::prefix('personas')->group(function () {
        Route::get('/index', [PersonaController::class, 'index'])->name('personas.index');
        Route::get('/crear', [PersonaController::class, 'crear'])->name('personas.crear');
        Route::post('/guardar', [PersonaController::class, 'guardar'])->name('personas.guardar');
        Route::get('/{slug}/editar', [PersonaController::class, 'editar'])->name('personas.editar');
        Route::put('/{slug}', [PersonaController::class, 'actualizar'])->name('personas.actualizar');
        Route::delete('/{slug}', [PersonaController::class, 'borrar'])->name('personas.borrar');
        Route::get('/{slug}', [PersonaController::class, 'mostrar'])->name('personas.mostrar');
    });

    // CUADROS ADMIN
    Route::prefix('cuadros')->group(function () {
        Route::get('/index', [CuadroController::class, 'index'])->name('cuadros.index');
        Route::get('/crear', [CuadroController::class, 'crear'])->name('cuadros.crear');
        Route::post('/guardar', [CuadroController::class, 'guardar'])->name('cuadros.guardar');
        Route::get('/editar/{cuadro}', [CuadroController::class, 'editar'])->name('cuadros.editar');
        Route::put('/actualizar/{cuadro}', [CuadroController::class, 'actualizar'])->name('cuadros.actualizar');
        Route::delete('/borrar/{cuadro}', [CuadroController::class, 'borrar'])->name('cuadros.borrar');
    });

    // Toggle visibility
    Route::post('/toggle-visibility', [VisibilityController::class, 'toggle'])->name('toggle-visibility');

});

});
