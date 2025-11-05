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


Route::get('/', function () {
    return redirect()->route('login.form');
});

// Login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login.post');

// Registro
Route::get('register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [LoginController::class, 'register'])->name('register.post');


Route::middleware(['admin'])->prefix('administrador')->group(function () {

    // Dashboard
    Route::get('/dashboard', [InicioController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Administradores
    Route::get('/listado', [AdministradorController::class, 'listado'])->name('administrador.listado');
    Route::post('/guardar', [AdministradorController::class, 'guardar'])->name('administrador.guardar');
    Route::get('/editar/{id}', [AdministradorController::class, 'editar'])->name('administrador.editar');
    Route::put('/actualizar/{id}', [AdministradorController::class, 'actualizar'])->name('administrador.actualizar');
    Route::get('/mostrar/{id}', [AdministradorController::class, 'mostrar'])->name('administrador.mostrar');
    Route::delete('/eliminar/{id}', [AdministradorController::class, 'eliminar'])->name('administrador.eliminar');

    //Secciones
    Route::get('/secciones/listado', [SeccionesController::class, 'listado'])->name('secciones.listado');
    Route::get('secciones/crear', [SeccionesController::class, 'crear'])->name('secciones.crear');
    Route::post('/secciones/guardar', [SeccionesController::class, 'guardar'])->name('secciones.guardar');
    Route::get('secciones/{id}/editar', [SeccionesController::class, 'editar'])->name('secciones.editar');
    Route::put('/secciones/{id}/actualizar', [SeccionesController::class, 'actualizar'])->name('secciones.actualizar');
    Route::get('secciones/{id}', [SeccionesController::class, 'mostrar'])->name('secciones.mostrar');
    Route::delete('secciones/{id}/borrar', [SeccionesController::class, 'borrar'])->name('secciones.borrar');
    Route::get('/secciones-videoteca', [SeccionesController::class, 'listadoConVideoteca'])->name('secciones.videoteca');
    Route::get('/secciones/24/videoteca', [SeccionesController::class, 'videoteca'])->name('secciones.videoteca');


    //Videoteca 

Route::get('/videoteca', [VideotecaController::class, 'index'])->name('videoteca.index');
Route::post('/videoteca/guardar', [VideotecaController::class, 'guardar'])->name('videoteca.guardar');
Route::get('/videoteca/editar/{id}', [VideotecaController::class, 'editar'])->name('videoteca.editar');
Route::put('/videoteca/actualizar/{id}', [VideotecaController::class, 'actualizar'])->name('videoteca.actualizar');
Route::delete('/videoteca/eliminar/{id}', [VideotecaController::class, 'eliminar'])->name('videoteca.eliminar');


    // Contenidos
    Route::get('/contenidos/listado', [ContenidosController::class, 'listado'])->name('contenidos.listado');
    Route::get('/contenidos/crear', [ContenidosController::class, 'crear'])->name('contenidos.crear');
    Route::post('/contenidos/guardar', [ContenidosController::class, 'guardar'])->name('contenidos.guardar');
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



// Cuadro
Route::prefix('cuadros')->group(function () {
    Route::get('/', [CuadroController::class, 'index'])->name('cuadros.index');
    Route::get('/crear', [CuadroController::class, 'crear'])->name('cuadros.crear');
    Route::post('/guardar', [CuadroController::class, 'guardar'])->name('cuadros.guardar');
    Route::get('/editar/{cuadro}', [CuadroController::class, 'editar'])->name('cuadros.editar');
    Route::put('/actualizar/{cuadro}', [CuadroController::class, 'actualizar'])->name('cuadros.actualizar');
    Route::delete('/borrar/{cuadro}', [CuadroController::class, 'borrar'])->name('cuadros.borrar');
});




// 🟦 AGRUPAMOS TODO BAJO /navbar
Route::prefix('navbar')->group(function() {

    // 🔹 SECCIONES PRINCIPALES DEL NAVBAR
    Route::get('secciones', [NavbarSeccionesController::class, 'index'])
        ->name('navbar.secciones.index');

    Route::get('secciones/crear', [NavbarSeccionesController::class, 'crear'])
        ->name('navbar.secciones.crear');

    Route::post('secciones', [NavbarSeccionesController::class, 'guardarSeccion'])
        ->name('navbar.secciones.guardar');

    Route::get('secciones/{seccion}/editar', [NavbarSeccionesController::class, 'editarSeccion'])
        ->name('navbar.secciones.editar');

    Route::put('secciones/{seccion}', [NavbarSeccionesController::class, 'actualizarSeccion'])
        ->name('navbar.secciones.actualizar');

    Route::delete('secciones/{seccion}', [NavbarSeccionesController::class, 'borrarSeccion'])
        ->name('navbar.secciones.borrar');


    // 🔹 SUBMENÚS (CONTENIDOS) DE CADA SECCIÓN
    Route::get('secciones/{seccion}/contenidos/crear', [NavbarSeccionesController::class, 'crearContenido'])
        ->name('navbar.contenidos.crear');

    Route::post('secciones/{seccion}/contenidos', [NavbarSeccionesController::class, 'guardarContenido'])
        ->name('navbar.contenidos.guardar');

    Route::get('contenidos/{contenido}/editar', [NavbarSeccionesController::class, 'editarContenido'])
        ->name('navbar.contenidos.editar');

    Route::put('contenidos/{contenido}', [NavbarSeccionesController::class, 'actualizarContenido'])
        ->name('navbar.contenidos.actualizar');

    Route::delete('contenidos/{contenido}', [NavbarSeccionesController::class, 'borrarContenido'])
        ->name('navbar.contenidos.borrar');



Route::prefix('banner')->group(function() {
    Route::get('/', [BannerController::class, 'mostrar'])->name('banner.mostrar');
    Route::get('/editar', [BannerController::class, 'editar'])->name('banner.editar');
    Route::post('/actualizar', [BannerController::class, 'actualizar'])->name('banner.actualizar');
    Route::delete('/borrar', [BannerController::class, 'borrar'])->name('banner.borrar');
    Route::post('/guardar', [BannerController::class, 'guardar'])->name('banner.guardar');
});



});

});
