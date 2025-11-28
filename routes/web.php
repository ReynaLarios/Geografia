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

/*
|--------------------------------------------------------------------------
| LOGIN / LOGOUT (público)
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login.form');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout'); // Solo 1 logout

/*
|--------------------------------------------------------------------------
| RUTAS ADMINISTRADOR (protegidas por middleware admin)
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->group(function () {

    // DASHBOARD
    Route::get('/dashboard', [InicioController::class, 'index'])->name('dashboard');

    // ADMINISTRADORES
    Route::prefix('administrador')->group(function () {
        Route::get('/listado', [AdministradorController::class, 'listado'])->name('administrador.listado');
        Route::put('/guardar', [AdministradorController::class, 'guardar'])->name('administrador.guardar');
        Route::get('/editar/{id}', [AdministradorController::class, 'editar'])->name('administrador.editar');
        Route::put('/actualizar/{id}', [AdministradorController::class, 'actualizar'])->name('administrador.actualizar');
        Route::get('/mostrar/{id}', [AdministradorController::class, 'mostrar'])->name('administrador.mostrar');
        Route::delete('/eliminar/{id}', [AdministradorController::class, 'eliminar'])->name('administrador.eliminar');
    });

    // PAGINA DE INICIO (admin)
    Route::prefix('inicio')->group(function () {
        Route::get('/dashboard', [InicioController::class, 'index'])->name('inicio.index');
        Route::get('/crear', [InicioController::class, 'create'])->name('inicio.create');
        Route::post('/', [InicioController::class, 'store'])->name('inicio.store');
        Route::get('/{inicio}', [InicioController::class, 'show'])->name('inicio.show');
        Route::get('/{inicio}/editar', [InicioController::class, 'edit'])->name('inicio.edit');
        Route::put('/{inicio}', [InicioController::class, 'update'])->name('inicio.update');
        Route::delete('/{inicio}', [InicioController::class, 'destroy'])->name('inicio.destroy');

        // CARRUSEL
        Route::get('/carrusel/create', [InicioController::class, 'createImagen'])->name('inicio.createImagen');
        Route::post('/carrusel/store', [InicioController::class, 'storeImagen'])->name('inicio.storeImagen');
        Route::get('/carrusel/{id}/edit', [InicioController::class, 'editImagen'])->name('inicio.editImagen');
        Route::put('/carrusel/{id}', [InicioController::class, 'updateImagen'])->name('inicio.updateImagen');
        Route::delete('/carrusel/{id}', [InicioController::class, 'destroyImagen'])->name('inicio.destroyImagen');

        // Borrar imagen específica
        Route::delete('/{id}/imagen/{campo}', [InicioController::class, 'borrarImagen'])->name('inicio.borrarImagen');
    });

    // NAVBAR SECCIONES
    Route::prefix('navbar/secciones')->group(function () {
        Route::get('/panel', [NavbarSeccionesController::class, 'panel'])->name('navbar.secciones.panel');
        Route::get('/index', [NavbarSeccionesController::class, 'index'])->name('navbar.secciones.index');
        Route::get('/crear', [NavbarSeccionesController::class, 'crear'])->name('navbar.secciones.crear');
        Route::post('/guardar', [NavbarSeccionesController::class, 'guardar'])->name('navbar.secciones.guardar');
        Route::get('/{id}', [NavbarSeccionesController::class, 'mostrar'])->name('navbar.secciones.mostrar');
        Route::get('/{id}/editar', [NavbarSeccionesController::class, 'editar'])->name('navbar.secciones.editar');
        Route::put('/{id}/actualizar', [NavbarSeccionesController::class, 'actualizar'])->name('navbar.secciones.actualizar');
        Route::delete('/{id}/borrar', [NavbarSeccionesController::class, 'borrar'])->name('navbar.secciones.borrar');
        Route::post('/{id}/cuadro/guardar', [NavbarSeccionesController::class, 'guardarCuadro'])->name('navbar.secciones.guardarCuadro');
        Route::delete('/{id}/cuadro/eliminar', [NavbarSeccionesController::class, 'eliminarCuadro'])->name('navbar.secciones.eliminarCuadro');
    });

    // NAVBAR CONTENIDOS
    Route::prefix('navbar/contenidos')->group(function () {
        Route::get('/index', [NavbarContenidosController::class, 'index'])->name('navbar.contenidos.index');
        Route::get('/crear', [NavbarContenidosController::class, 'crear'])->name('navbar.contenidos.crear');
        Route::post('/guardar', [NavbarContenidosController::class, 'guardar'])->name('navbar.contenidos.guardar');
        Route::get('/{id}', [NavbarContenidosController::class, 'mostrar'])->name('navbar.contenidos.mostrar');
        Route::get('/{id}/editar', [NavbarContenidosController::class, 'editar'])->name('navbar.contenidos.editar');
        Route::put('/{id}/actualizar', [NavbarContenidosController::class, 'actualizar'])->name('navbar.contenidos.actualizar');
        Route::delete('/{id}/borrar', [NavbarContenidosController::class, 'borrar'])->name('navbar.contenidos.borrar');
    });

    // SECCIONES ADMIN
    Route::prefix('secciones')->group(function () {
        Route::get('/listado', [SeccionesController::class, 'listado'])->name('secciones.listado');
        Route::get('/crear', [SeccionesController::class, 'crear'])->name('secciones.crear');
        Route::post('/guardar', [SeccionesController::class, 'guardar'])->name('secciones.guardar');
        Route::get('/{id}/editar', [SeccionesController::class, 'editar'])->name('secciones.editar');
        Route::put('/{id}/actualizar', [SeccionesController::class, 'actualizar'])->name('secciones.actualizar');
        Route::post('/{id}/cuadro/guardar', [SeccionesController::class, 'guardarCuadro'])->name('secciones.cuadro.guardar');
        Route::delete('/cuadros/{id}/eliminar', [SeccionesController::class, 'eliminarCuadro'])->name('cuadros.eliminar');
        Route::post('/{id}/archivo', [SeccionesController::class, 'guardarArchivo'])->name('secciones.archivo.guardar');
        Route::delete('/archivos/{id}/eliminar', [SeccionesController::class, 'eliminarArchivo'])->name('archivos.eliminar');
        Route::get('/{id}', [SeccionesController::class, 'mostrar'])->name('secciones.mostrar');
        Route::delete('/{id}/borrar', [SeccionesController::class, 'borrar'])->name('secciones.borrar');
    });

    // VIDEOTECA ADMIN
    Route::prefix('videoteca')->group(function () {
        Route::get('/index', [VideotecaController::class, 'index'])->name('videoteca.index');
        Route::post('/guardar', [VideotecaController::class, 'guardar'])->name('videoteca.guardar');
        Route::get('/editar/{id}', [VideotecaController::class, 'editar'])->name('videoteca.editar');
        Route::put('/actualizar/{id}', [VideotecaController::class, 'actualizar'])->name('videoteca.actualizar');
        Route::delete('/eliminar/{id}', [VideotecaController::class, 'eliminar'])->name('videoteca.eliminar');
    });

    // CONTENIDOS ADMIN
    Route::prefix('contenidos')->group(function () {
        Route::get('/listado', [ContenidosController::class, 'listado'])->name('contenidos.listado');
        Route::get('/crear', [ContenidosController::class, 'crear'])->name('contenidos.crear');
        Route::post('/guardar', [ContenidosController::class, 'guardar'])->name('contenidos.guardar');
        Route::get('/{id}/editar', [ContenidosController::class, 'editar'])->name('contenidos.editar');
        Route::put('/{id}/actualizar', [ContenidosController::class, 'actualizar'])->name('contenidos.actualizar');
        Route::get('/{id}/mostrar', [ContenidosController::class, 'mostrar'])->name('contenidos.mostrar');
        Route::delete('/{id}/borrar', [ContenidosController::class, 'borrar'])->name('contenidos.borrar');
    });

    // ARCHIVOS ADMIN
    Route::prefix('archivos')->group(function () {
        Route::get('/{contenido_id}/listar', [ArchivoController::class, 'listar'])->name('archivos.listar');
        Route::get('/{contenido_id}/crear', [ArchivoController::class, 'crear'])->name('archivos.crear');
        Route::put('/{contenido_id}/guardar', [ArchivoController::class, 'guardar'])->name('archivos.guardar');
        Route::delete('/{id}/borrar', [ArchivoController::class, 'borrar'])->name('archivos.borrar');
        Route::get('/{id}/descargar', [ArchivoController::class, 'descargar'])->name('archivos.descargar');
    });

    // BANNERS ADMIN
    Route::prefix('banners')->group(function () {
        Route::get('/', [BannerController::class, 'index'])->name('banner.index');
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
        Route::get('/{persona}/editar', [PersonaController::class, 'editar'])->name('personas.editar');
        Route::put('/{persona}', [PersonaController::class, 'actualizar'])->name('personas.actualizar');
        Route::delete('/{persona}', [PersonaController::class, 'borrar'])->name('personas.borrar');
        Route::get('/{persona}', [PersonaController::class, 'mostrar'])->name('personas.mostrar');
    });

    // CUADROS ADMIN
    Route::prefix('cuadros')->group(function () {
        Route::get('/', [CuadroController::class, 'index'])->name('cuadros.index');
        Route::get('/crear', [CuadroController::class, 'crear'])->name('cuadros.crear');
        Route::post('/guardar', [CuadroController::class, 'guardar'])->name('cuadros.guardar');
        Route::get('/editar/{cuadro}', [CuadroController::class, 'editar'])->name('cuadros.editar');
        Route::put('/actualizar/{cuadro}', [CuadroController::class, 'actualizar'])->name('cuadros.actualizar');
        Route::delete('/borrar/{cuadro}', [CuadroController::class, 'borrar'])->name('cuadros.borrar');
    });

    // Toggle visibility
    Route::post('/toggle-visibility', [VisibilityController::class, 'toggle'])->name('toggle-visibility');

}); // ← fin middleware admin

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (sin prefijo)
|--------------------------------------------------------------------------
*/

// PERSONAS
Route::get('/academicos', [PersonaController::class, 'publicIndex'])->name('public.personas.index');
Route::get('/academicos/{slug}', [PersonaController::class, 'publicShow'])->name('public.personas.show');

// PÁGINA PRINCIPAL
Route::get('/', [PublicController::class, 'inicio'])->name('public.inicio.index');
Route::get('/inicio/{id}', [PublicController::class, 'inicioShow'])->name('public.inicio.show');

// CARRUSEL
Route::get('/carrusel', [PublicController::class, 'carrusel'])->name('public.carrusel');

// NAVBAR
Route::get('/navbar/secciones', [PublicController::class, 'navbarSeccionesIndex'])->name('public.navbar.secciones.index');
Route::get('/navbar/secciones/{slug}', [PublicController::class, 'navbarSeccionesMostrar'])->name('public.navbar.secciones.show');
Route::get('/navbar/contenidos', [PublicController::class, 'navbarContenidosIndex'])->name('public.navbar.contenidos.index');
Route::get('/navbar/contenido/{slug}', [PublicController::class, 'navbarContenidoMostrar'])->name('public.navbar.contenido.show');

// SECCIONES PÚBLICAS
Route::get('/secciones', [PublicController::class, 'seccionesIndex'])->name('public.secciones.index');
Route::get('/secciones/{slug}', [PublicController::class, 'seccionesMostrar'])->name('public.secciones.show');

// CONTENIDOS PÚBLICOS
Route::get('/contenidos/public', [PublicController::class, 'contenidosIndex'])->name('public.contenidos.index');
Route::get('/contenidos/{slug}', [PublicController::class, 'contenidosMostrar'])->name('public.contenidos.show');

// CUADROS
Route::get('/cuadros', [PublicController::class, 'cuadrosIndex'])->name('public.cuadros.index');

// VIDEOTECA
Route::get('/videoteca', [VideotecaController::class, 'publicIndex'])->name('videoteca');

// BUSCADOR
Route::get('/buscador/autocomplete', [BuscadorController::class, 'autocomplete'])->name('buscador.autocomplete');
Route::get('/buscador/resultados', [BuscadorController::class, 'resultados'])->name('buscador.resultados');
