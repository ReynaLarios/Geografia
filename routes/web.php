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

//Rutas publicas
Route::prefix('')->group(function () {
    Route::get('/', [PublicController::class, 'inicio'])->name('public.inicio');
    Route::get('/seccion/{id}', [PublicController::class, 'verSeccion'])->name('public.verSeccion');
    Route::get('/contenido/{id}', [PublicController::class, 'verContenido'])->name('public.verContenido');
    Route::get('/videoteca', [PublicController::class, 'videoteca'])->name('public.videoteca');
});

//Login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login.post');

Route::get('register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [LoginController::class, 'register'])->name('register.post');


//adiministrador autenticado
Route::middleware(['admin'])->prefix('administrador')->group(function () {

    // Dashboard principal
    Route::get('/dashboard', [InicioController::class, 'index'])->name('dashboard');
    Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

    // Administradores
    Route::get('/listado', [AdministradorController::class, 'listado'])->name('administrador.listado');
    Route::put('/guardar', [AdministradorController::class, 'guardar'])->name('administrador.guardar');
    Route::get('/editar/{id}', [AdministradorController::class, 'editar'])->name('administrador.editar');
    Route::put('/actualizar/{id}', [AdministradorController::class, 'actualizar'])->name('administrador.actualizar');
    Route::get('/mostrar/{id}', [AdministradorController::class, 'mostrar'])->name('administrador.mostrar');
    Route::delete('/eliminar/{id}', [AdministradorController::class, 'eliminar'])->name('administrador.eliminar');


    //Videoteca
Route::get('/videoteca', [VideotecaController::class, 'index'])->name('videoteca');

// Rutas CRUD de videoteca
Route::post('/videoteca/guardar', [VideotecaController::class, 'guardar'])->name('videoteca.guardar');
Route::get('/videoteca/editar/{id}', [VideotecaController::class, 'editar'])->name('videoteca.editar');
Route::put('/videoteca/actualizar/{id}', [VideotecaController::class, 'actualizar'])->name('videoteca.actualizar');
Route::delete('/videoteca/eliminar/{id}', [VideotecaController::class, 'eliminar'])->name('videoteca.eliminar');

// ---- Secciones ----
Route::get('/secciones/listado', [SeccionesController::class, 'listado'])->name('secciones.listado');
Route::get('/secciones/crear', [SeccionesController::class, 'crear'])->name('secciones.crear');
Route::post('/secciones/guardar', [SeccionesController::class, 'guardar'])->name('secciones.guardar');
Route::get('/secciones/{id}/editar', [SeccionesController::class, 'editar'])->name('secciones.editar');
Route::put('/secciones/{id}/actualizar', [SeccionesController::class, 'actualizar'])->name('secciones.actualizar');
Route::delete('/secciones/{id}/borrar', [SeccionesController::class, 'borrar'])->name('secciones.borrar');
Route::get('/secciones/{id}', [SeccionesController::class, 'mostrar'])->name('secciones.mostrar');


    // Contenidos
    Route::get('/contenidos/listado', [ContenidosController::class, 'listado'])->name('contenidos.listado');
    Route::get('/contenidos/crear', [ContenidosController::class, 'crear'])->name('contenidos.crear');
    Route::put('/contenidos/guardar', [ContenidosController::class, 'guardar'])->name('contenidos.guardar');
    Route::get('/contenidos/{id}/editar', [ContenidosController::class, 'editar'])->name('contenidos.editar');
    Route::put('/contenidos/{id}/actualizar', [ContenidosController::class, 'actualizar'])->name('contenidos.actualizar');
    Route::get('/contenidos/{id}/mostrar', [ContenidosController::class, 'mostrar'])->name('contenidos.mostrar');
    Route::delete('/contenidos/{id}/borrar', [ContenidosController::class, 'borrar'])->name('contenidos.borrar');

// Archivos asociados a contenido
Route::get('/contenidos/{contenido_id}/archivos', [ArchivoController::class, 'listar'])->name('archivos.listar');
Route::get('/contenidos/{contenido_id}/archivos/crear', [ArchivoController::class, 'crear'])->name('archivos.crear');
Route::post('/contenidos/{contenido_id}/archivos/guardar', [ArchivoController::class, 'guardar'])->name('archivos.guardar');
Route::delete('/archivos/{id}/borrar', [ArchivoController::class, 'borrar'])->name('archivos.borrar');
Route::get('/archivos/{id}/descargar', [ArchivoController::class, 'descargar'])->name('archivos.descargar');

//Banner
Route::post('/administrador/banner/guardar', [ArchivoController::class, 'guardarBannerAdmin'])->name('archivos.guardarBannerAdmin');


// Página de inicio
Route::get('/inicio', [InicioController::class, 'index'])->name('inicio.index');
Route::get('/inicio/crear', [InicioController::class, 'create'])->name('inicio.create');
Route::post('/inicio', [InicioController::class, 'store'])->name('inicio.store');
Route::get('/inicio/{inicio}', [InicioController::class, 'show'])->name('inicio.show');
Route::get('/inicio/{inicio}/editar', [InicioController::class, 'edit'])->name('inicio.edit');
Route::put('/inicio/{inicio}', [InicioController::class, 'update'])->name('inicio.update');
Route::delete('/inicio/{inicio}', [InicioController::class, 'destroy'])->name('inicio.destroy');
Route::delete('inicio/{id}/imagen/{campo}', [InicioController::class, 'borrarImagen'])->name('inicio.borrarImagen');


// Cuadro
Route::prefix('cuadros')->group(function () {
    Route::get('/', [CuadroController::class, 'index'])->name('cuadros.index');
    Route::get('/crear', [CuadroController::class, 'crear'])->name('cuadros.crear');
    Route::post('/guardar', [CuadroController::class, 'guardar'])->name('cuadros.guardar');
    Route::get('/editar/{cuadro}', [CuadroController::class, 'editar'])->name('cuadros.editar');
    Route::put('/actualizar/{cuadro}', [CuadroController::class, 'actualizar'])->name('cuadros.actualizar');
    Route::delete('/borrar/{cuadro}', [CuadroController::class, 'borrar'])->name('cuadros.borrar');
});


// Navbar Secciones
// =======================
Route::get('/', [NavbarSeccionesController::class, 'panel'])->name('navbar.secciones.panel');
Route::get('/administrador/navbar/secciones', [App\Http\Controllers\NavbarSeccionesController::class, 'index'])->name('navbar.secciones.index');
Route::get('/administrador/navbar/secciones/crear', [App\Http\Controllers\NavbarSeccionesController::class, 'crear'])->name('navbar.secciones.crear');
Route::post('/administrador/navbar/secciones/guardar', [App\Http\Controllers\NavbarSeccionesController::class, 'guardar'])->name('navbar.secciones.guardar');
Route::get('/administrador/navbar/secciones/{id}', [App\Http\Controllers\NavbarSeccionesController::class, 'mostrar'])->name('navbar.secciones.mostrar');
Route::get('/administrador/navbar/secciones/{id}/editar', [App\Http\Controllers\NavbarSeccionesController::class, 'editar'])->name('navbar.secciones.editar');
Route::put('administrador/navbar/secciones/{id}/actualizar', [NavbarSeccionesController::class, 'actualizar'])->name('navbar.secciones.actualizar');
Route::delete('/administrador/navbar/secciones/{id}/borrar', [App\Http\Controllers\NavbarSeccionesController::class, 'borrar'])->name('navbar.secciones.borrar');

// =======================
// Navbar Contenidos
// =======================
Route::get('/administrador/navbar/contenidos', [App\Http\Controllers\NavbarContenidosController::class, 'index'])->name('navbar.contenidos.index');
Route::get('/administrador/navbar/contenidos/crear', [App\Http\Controllers\NavbarContenidosController::class, 'crear'])->name('navbar.contenidos.crear');
Route::post('/administrador/navbar/contenidos/guardar', [App\Http\Controllers\NavbarContenidosController::class, 'guardar'])->name('navbar.contenidos.guardar');
Route::get('/administrador/navbar/contenidos/{id}', [App\Http\Controllers\NavbarContenidosController::class, 'mostrar'])->name('navbar.contenidos.mostrar');
Route::get('/administrador/navbar/contenidos/{id}/editar', [App\Http\Controllers\NavbarContenidosController::class, 'editar'])->name('navbar.contenidos.editar');
Route::put('/administrador/navbar/contenidos/{id}/actualizar', [App\Http\Controllers\NavbarContenidosController::class, 'actualizar'])->name('navbar.contenidos.actualizar');
Route::delete('/administrador/navbar/contenidos/{id}', [App\Http\Controllers\NavbarContenidosController::class, 'borrar'])->name('navbar.contenidos.borrar');



// Carrusel
Route::get('inicio/carrusel/create', [InicioController::class, 'createImagen'])->name('inicio.createImagen');
Route::post('inicio/carrusel/store', [InicioController::class, 'storeImagen'])->name('inicio.storeImagen');
Route::get('inicio/carrusel/{id}/edit', [InicioController::class, 'editImagen'])->name('inicio.editImagen');
Route::put('inicio/carrusel/{id}', [InicioController::class, 'updateImagen'])->name('inicio.updateImagen');
Route::delete('inicio/carrusel/{id}', [InicioController::class, 'destroyImagen'])->name('inicio.destroyImagen');
});

// Banners
Route::get('/administrador/banner/index', [BannerController::class, 'index'])->name('banner.index');
Route::post('/administrador/banner/guardar', [BannerController::class, 'guardar'])->name('banner.guardar');
Route::get('/administrador/banner/editar', [BannerController::class, 'editar'])->name('banner.editar');
Route::post('/administrador/banner/actualizar', [BannerController::class, 'actualizar'])->name('banner.actualizar');
Route::delete('/administrador/banner/borrar', [BannerController::class, 'borrar'])->name('banner.borrar');



