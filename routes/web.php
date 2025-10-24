<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SeccionesController;
use App\Http\Controllers\ContenidosController;
use App\Http\Controllers\VideoController;
use App\Http\Controllers\ArchivoController;
use App\Http\Controllers\InicioController;
use App\Http\Controllers\Administrador\AdministradorController;
use App\Http\Controllers\Administrador\LoginController;

//RUTAS PÚBLICAS
Route::get('/', [LoginController::class, 'showLoginForm'])->name('administrador.login');
Route::post('/administrador/login', [LoginController::class, 'login'])->name('administrador.login.post');
Route::post('/administrador/logout', [LoginController::class, 'logout'])->name('administrador.logout');

Route::get('/administrador/registrar', [LoginController::class, 'showRegisterForm'])->name('administrador.register');
Route::post('/administrador/registrar', [LoginController::class, 'register'])->name('administrador.registrar');

//PANEL PROTEGIDO
Route::middleware(['admin'])->prefix('administrador')->group(function () {

    // Administradores
    Route::get('/listado', [AdministradorController::class, 'listado'])->name('administrador.listado');
    Route::get('/login', [AdministradorController::class, 'login'])->name('administrador.login');
    Route::post('/guardar', [AdministradorController::class, 'guardar'])->name('administrador.guardar');
    Route::get('/editar/{id}', [AdministradorController::class, 'editar'])->name('administrador.{id}.editar');
    Route::put('/actualizar/{id}', [AdministradorController::class, 'actualizar'])->name('administrador.{id}.actualizar');
    Route::get('/mostrar/{id}', [AdministradorController::class, 'mostrar'])->name('administrador.{id}.mostrar');
    Route::delete('/eliminar/{id}', [AdministradorController::class, 'eliminar'])->name('administrador.{id}.eliminar');

    // Secciones
    Route::get('/secciones/crear', [SeccionesController::class, 'crear'])->name('secciones.crear');
    Route::post('/secciones/guardar', [SeccionesController::class, 'guardar'])->name('secciones.guardar');
    Route::get('/secciones/listar', [SeccionesController::class, 'listar'])->name('secciones.listar');
    Route::get('/secciones/{id}/editar', [SeccionesController::class, 'editar'])->name('secciones.{id}.editar');
    Route::put('/secciones/{id}/actualizar', [SeccionesController::class, 'actualizar'])->name('secciones.{id}.actualizar');
    Route::get('/secciones/{id}/mostrar', [SeccionesController::class, 'mostrar'])->name('secciones.{id}.mostrar');
    Route::delete('/secciones/{id}/borrar', [SeccionesController::class, 'borrar'])->name('secciones.{id}.borrar');

    // Contenidos
    Route::get('/contenidos/crear', [ContenidosController::class, 'crear'])->name('contenidos.crear');
    Route::post('/contenidos/guardar', [ContenidosController::class, 'guardar'])->name('contenidos.guardar');
    Route::get('/contenidos/listar', [ContenidosController::class, 'listar'])->name('contenidos.listar');
    Route::get('/contenidos/{id}/editar', [ContenidosController::class, 'editar'])->name('contenidos.{id}.editar');
    Route::put('/contenidos/{id}/actualizar', [ContenidosController::class, 'actualizar'])->name('contenidos.{id}.actualizar');
    Route::get('/contenidos/{id}/mostrar', [ContenidosController::class, 'mostrar'])->name('contenidos.{id}.mostrar');
    Route::delete('/contenidos/{id}/borrar', [ContenidosController::class, 'borrar'])->name('contenidos.{id}.borrar');

  
    Route::get('/contenidos/{contenido_id}/archivos', [ArchivoController::class, 'listar'])->name('archivos.listar');
    Route::get('/contenidos/{contenido_id}/archivos/crear', [ArchivoController::class, 'crear'])->name('archivos.crear');
    Route::post('/contenidos/{contenido_id}/archivos/guardar', [ArchivoController::class, 'guardar'])->name('archivos.guardar');
    Route::delete('/archivos/{id}/borrar', [ArchivoController::class, 'borrar'])->name('archivos.borrar');
    Route::get('/archivos/{id}/descargar', [ArchivoController::class, 'descargar'])->name('archivos.descargar');

    // Videoteca
    Route::get('/videoteca', [VideoController::class, 'index'])->name('videoteca.index');
    Route::get('/videoteca/crear', [VideoController::class, 'create'])->name('videoteca.create');
    Route::post('/videoteca', [VideoController::class, 'store'])->name('videoteca.store');
    Route::get('/videoteca/{id}', [VideoController::class, 'show'])->name('videoteca.show');
    Route::get('/videoteca/{id}/editar', [VideoController::class, 'edit'])->name('videoteca.edit');
    Route::put('/videoteca/{id}', [VideoController::class, 'update'])->name('videoteca.update');
    Route::delete('/videoteca/{id}', [VideoController::class, 'destroy'])->name('videoteca.destroy');

    // Panel principal
    Route::get('/inicio', [InicioController::class, 'index'])->name('dashboard');

    // Ruta de prueba middleware
    Route::get('/prueba', function () {
        return "¡Middleware funcionando!";
    });
});
