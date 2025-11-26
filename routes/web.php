<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeccionesController;
use App\Http\Controllers\ContenidosController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\Administrador\AdministradorController;
use App\Http\Controllers\Administrador\LoginController;
use App\Http\Controllers\Auth\ForgotPasswordController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\CuadroController;
use App\Http\Controllers\VideotecaController;
use App\Http\Controllers\NavbarSeccionesController;
use App\Http\Controllers\NavbarContenidosController;
use App\Http\Controllers\BannerController;
use App\Http\Controllers\PublicController;
use App\Http\Controllers\VisibilityController;
use App\Http\Controllers\PersonaController;
use App\Http\Controllers\BuscadorController;

//------------------------------------------------------------------------RUTAS PÚBLICAS-------------------------------------------------------------------------------------------


    //PERSONAS
 Route::prefix('public')->group(function () {
    Route::get('/personas', [PersonaController::class, 'publicIndex'])->name('public.personas.index');
    Route::get('/personas/{slug}', [PersonaController::class, 'publicShow'])->name('public.personas.show');
});


    // INICIO
    Route::get('/', [PublicController::class, 'inicio'])->name('public.inicio.index');
    Route::get('/inicio/{id}', [PublicController::class, 'inicioShow'])->name('public.inicio.show');

    // CARRUSEL
    Route::get('/carrusel', [PublicController::class, 'carrusel'])->name('public.carrusel');

    // NAVBAR - Secciones
    Route::get('/navbar/secciones', [PublicController::class, 'navbarSeccionesIndex'])->name('public.navbar.secciones.index');
    Route::get('/navbar/secciones/{slug}', [PublicController::class, 'navbarSeccionesMostrar'])->name('public.navbar.secciones.show');

    // NAVBAR - Contenidos
    Route::get('/navbar/contenidos', [PublicController::class, 'navbarContenidosIndex'])->name('public.navbar.contenidos.index');
    Route::get('/navbar/contenido/{slug}', [PublicController::class, 'navbarContenidoMostrar'])->name('public.navbar.contenido.show');

    // SECCIONES públicas
    Route::get('/secciones', [PublicController::class, 'seccionesIndex'])->name('public.secciones.index');
    Route::get('/secciones/{slug}', [PublicController::class, 'seccionesMostrar'])->name('public.secciones.show');

    // CONTENIDOS públicos
    Route::get('/contenidos', [PublicController::class, 'contenidosIndex'])->name('public.contenidos.index');
    Route::get('/contenidos/{slug}', [PublicController::class, 'contenidosMostrar'])->name('public.contenidos.show');

    // CUADROS
    Route::get('/cuadros', [PublicController::class, 'cuadrosIndex'])->name('public.cuadros.index');

    // VIDEOTECA
  Route::get('/videoteca', [VideotecaController::class, 'publicIndex'])->name('videoteca');

//BUSCADOR

Route::get('/buscador/autocomplete', [BuscadorController::class, 'autocomplete'])->name('buscador.autocomplete');
Route::get('/buscador/resultados', [BuscadorController::class, 'resultados'])->name('buscador.resultados');










//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//LOGIN
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login.post');

Route::get('register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [LoginController::class, 'register'])->name('register.post');
//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//ADMINISTRADOR AUTENTICADO
Route::middleware(['admin'])->prefix('administrador')->group(function () {

// ADMINISTRADORES
Route::get('/listado', [AdministradorController::class, 'listado'])->name('administrador.listado');
Route::put('/guardar', [AdministradorController::class, 'guardar'])->name('administrador.guardar');
Route::get('/editar/{id}', [AdministradorController::class, 'editar'])->name('administrador.editar');
Route::put('/actualizar/{id}', [AdministradorController::class, 'actualizar'])->name('administrador.actualizar');
Route::get('/mostrar/{id}', [AdministradorController::class, 'mostrar'])->name('administrador.mostrar');
Route::delete('/eliminar/{id}', [AdministradorController::class, 'eliminar'])->name('administrador.eliminar');

//-----------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//DASHBOARD
Route::get('/dashboard', [InicioController::class, 'index'])->name('dashboard');
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');
//PAGINA DE INICIO
Route::get('/inicio', [InicioController::class, 'index'])->name('inicio.index');
Route::get('/inicio/crear', [InicioController::class, 'create'])->name('inicio.create');
Route::post('/inicio', [InicioController::class, 'store'])->name('inicio.store');
Route::get('/inicio/{inicio}', [InicioController::class, 'show'])->name('inicio.show');
Route::get('/inicio/{inicio}/editar', [InicioController::class, 'edit'])->name('inicio.edit');
Route::put('/inicio/{inicio}', [InicioController::class, 'update'])->name('inicio.update');
Route::delete('/inicio/{inicio}', [InicioController::class, 'destroy'])->name('inicio.destroy');
Route::delete('inicio/{id}/imagen/{campo}', [InicioController::class, 'borrarImagen'])->name('inicio.borrarImagen');
//CARROUSEL
Route::get('inicio/carrusel/create', [InicioController::class, 'createImagen'])->name('inicio.createImagen');
Route::post('inicio/carrusel/store', [InicioController::class, 'storeImagen'])->name('inicio.storeImagen');
Route::get('inicio/carrusel/{id}/edit', [InicioController::class, 'editImagen'])->name('inicio.editImagen');
Route::put('inicio/carrusel/{id}', [InicioController::class, 'updateImagen'])->name('inicio.updateImagen');
Route::delete('inicio/carrusel/{id}', [InicioController::class, 'destroyImagen'])->name('inicio.destroyImagen');

//-------------------------------------------------------------------------NAVBAR-------------------------------------------------------------------------------------------------------------
//NAVBAR SECCIONES
Route::get('/', [NavbarSeccionesController::class, 'panel'])->name('navbar.secciones.panel');
Route::get('/navbar/secciones', [NavbarSeccionesController::class, 'index'])->name('navbar.secciones.index');
Route::get('navbar/secciones/crear', [NavbarSeccionesController::class, 'crear'])->name('navbar.secciones.crear');
Route::post('navbar/secciones/guardar', [NavbarSeccionesController::class, 'guardar'])->name('navbar.secciones.guardar');
Route::get('navbar/secciones/{id}', [NavbarSeccionesController::class, 'mostrar'])->name('navbar.secciones.mostrar');
Route::get('navbar/secciones/{id}/editar', [NavbarSeccionesController::class, 'editar'])->name('navbar.secciones.editar');
Route::put('navbar/secciones/{id}/actualizar', [NavbarSeccionesController::class, 'actualizar'])->name('navbar.secciones.actualizar');
Route::delete('navbar/secciones/{id}/borrar', [NavbarSeccionesController::class, 'borrar'])->name('navbar.secciones.borrar');
//CUADROS DENTRO DE NAVBAR SECCIONES
Route::post('/guardar-cuadro/{id}', [NavbarSeccionesController::class, 'guardarCuadro'])->name('navbar.secciones.guardarCuadro');
Route::delete('/eliminar-cuadro/{id}', [NavbarSeccionesController::class, 'eliminarCuadro'])->name('navbar.secciones.eliminarCuadro');


//NAVBAR CONTENIDOS
Route::get('/navbar/contenidos', [NavbarContenidosController::class, 'index'])->name('navbar.contenidos.index');
Route::get('/navbar/contenidos/crear', [NavbarContenidosController::class, 'crear'])->name('navbar.contenidos.crear');
Route::post('/navbar/contenidos/guardar', [NavbarContenidosController::class, 'guardar'])->name('navbar.contenidos.guardar');
Route::get('/navbar/contenidos/{id}', [NavbarContenidosController::class, 'mostrar'])->name('navbar.contenidos.mostrar');
Route::get('/navbar/contenidos/{id}/editar', [NavbarContenidosController::class, 'editar'])->name('navbar.contenidos.editar');
Route::put('/navbar/contenidos/{id}/actualizar', [NavbarContenidosController::class, 'actualizar'])->name('navbar.contenidos.actualizar');
Route::delete('navbar/contenidos/{id}', [NavbarContenidosController::class, 'borrar'])->name('navbar.contenidos.borrar');

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------

//-----------------------------------------------------------------------------------SIDEBAR----------------------------------------------------------------------------------------------
//SECCIONES
Route::get('/secciones/listado', [SeccionesController::class, 'listado'])->name('secciones.listado');
Route::get('/secciones/crear', [SeccionesController::class, 'crear'])->name('secciones.crear');
Route::post('/secciones/guardar', [SeccionesController::class, 'guardar'])->name('secciones.guardar');
Route::get('/secciones/{id}/editar', [SeccionesController::class, 'editar'])->name('secciones.editar');
Route::put('/secciones/{id}/actualizar', [SeccionesController::class, 'actualizar'])->name('secciones.actualizar');
Route::delete('/secciones/{id}/borrar', [SeccionesController::class, 'borrar'])->name('secciones.borrar');
Route::get('/secciones/{id}', [SeccionesController::class, 'mostrar'])->name('secciones.mostrar');
//CUADROS DENTRO DE SECCIONES
Route::post('secciones/{id}/cuadro/guardar', [SeccionesController::class, 'guardarCuadro'])->name('secciones.cuadro.guardar');
Route::delete('cuadros/{id}/eliminar', [SeccionesController::class, 'eliminarCuadro'])->name('cuadros.eliminar');
//ARCHIVOS DENTRO DE SECCIONES 
Route::post('secciones/{id}/archivo', [SeccionesController::class, 'guardarArchivo'])->name('secciones.archivo.guardar');
Route::delete('archivos/{id}/eliminar', [SeccionesController::class, 'eliminarArchivo'])->name('archivos.eliminar');
//VIDEOTECA
Route::get('/videoteca/index', [VideotecaController::class, 'index'])->name('videoteca.index');
Route::post('/videoteca/guardar', [VideotecaController::class, 'guardar'])->name('videoteca.guardar');
Route::get('/videoteca/editar/{id}', [VideotecaController::class, 'editar'])->name('videoteca.editar');
Route::put('/videoteca/actualizar/{id}', [VideotecaController::class, 'actualizar'])->name('videoteca.actualizar');
Route::delete('/videoteca/eliminar/{id}', [VideotecaController::class, 'eliminar'])->name('videoteca.eliminar');



//CONTENIDOS
Route::get('/contenidos/listado', [ContenidosController::class, 'listado'])->name('contenidos.listado');
Route::get('/contenidos/crear', [ContenidosController::class, 'crear'])->name('contenidos.crear');
Route::post('/contenidos/guardar', [ContenidosController::class, 'guardar'])->name('contenidos.guardar');
Route::get('/contenidos/{id}/editar', [ContenidosController::class, 'editar'])->name('contenidos.editar');
Route::put('/contenidos/{id}/actualizar', [ContenidosController::class, 'actualizar'])->name('contenidos.actualizar');
Route::get('/contenidos/{id}/mostrar', [ContenidosController::class, 'mostrar'])->name('contenidos.mostrar');
Route::delete('/contenidos/{id}/borrar', [ContenidosController::class, 'borrar'])->name('contenidos.borrar');
//ARCHIVOS DENTRO DE CONTENIDOS
Route::get('/contenidos/{contenido_id}/archivos', [ArchivoController::class, 'listar'])->name('archivos.listar');
Route::get('/contenidos/{contenido_id}/archivos/crear', [ArchivoController::class, 'crear'])->name('archivos.crear');
Route::put('/contenidos/{contenido_id}/archivos/guardar', [ArchivoController::class, 'guardar'])->name('archivos.guardar');
Route::delete('/archivos/{id}/borrar', [ArchivoController::class, 'borrar'])->name('archivos.borrar');
Route::get('/archivos/{id}/descargar', [ArchivoController::class, 'descargar'])->name('archivos.descargar');

//--------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------------



//BANNER
Route::get('/banners', [BannerController::class, 'index'])->name('banner.index');
Route::get('/banners/editar', [BannerController::class, 'editar'])->name('banner.editar');
Route::post('/banners/actualizar', [BannerController::class, 'actualizar'])->name('banner.actualizar');
Route::post('/banners/guardar', [BannerController::class, 'guardar'])->name('banner.guardar');
Route::delete('/banners/borrar', [BannerController::class, 'borrar'])->name('banner.borrar');


// PERSONAS - ADMIN
Route::prefix('personas')->name('personas.')->group(function () {

    Route::get('/index', [PersonaController::class, 'index'])->name('index');
    Route::get('/crear', [PersonaController::class, 'crear'])->name('crear');
    Route::post('/guardar', [PersonaController::class, 'guardar'])->name('guardar');
    
    Route::get('/{persona}/editar', [PersonaController::class, 'editar'])->name('editar');
    Route::put('/{persona}', [PersonaController::class, 'actualizar'])->name('actualizar');
    
    Route::delete('/{persona}', [PersonaController::class, 'borrar'])->name('borrar');
    Route::get('/{persona}', [PersonaController::class, 'mostrar'])->name('mostrar');
});

Route::post('/toggle-visibility', [VisibilityController::class, 'toggle'])->name('toggle-visibility');










//CUADRO
Route::prefix('cuadros')->group(function () {
Route::get('/', [CuadroController::class, 'index'])->name('cuadros.index');
Route::get('/crear', [CuadroController::class, 'crear'])->name('cuadros.crear');
Route::post('/guardar', [CuadroController::class, 'guardar'])->name('cuadros.guardar');
Route::get('/editar/{cuadro}', [CuadroController::class, 'editar'])->name('cuadros.editar');
Route::put('/actualizar/{cuadro}', [CuadroController::class, 'actualizar'])->name('cuadros.actualizar');
Route::delete('/borrar/{cuadro}', [CuadroController::class, 'borrar'])->name('cuadros.borrar');


});
});




