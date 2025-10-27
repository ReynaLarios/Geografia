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

/*
|--------------------------------------------------------------------------
| RUTAS PÚBLICAS (Login / Registro / Recuperación de contraseña)
|--------------------------------------------------------------------------
*/
// Redirigir la raíz al login
Route::get('/', function () {
    return redirect()->route('login.form');
});

// Login
Route::get('login', [LoginController::class, 'showLoginForm'])->name('login.form');
Route::post('login', [LoginController::class, 'login'])->name('login.post');

// Registro
Route::get('register', [LoginController::class, 'showRegisterForm'])->name('register.form');
Route::post('register', [LoginController::class, 'register'])->name('register.post');

// Recuperación de contraseña
Route::get('password/forgot', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [ResetPasswordController::class, 'reset'])->name('password.update');

/*
|--------------------------------------------------------------------------
| Rutas protegidas del administrador
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->prefix('administrador')->group(function () {

    // Dashboard
    Route::get('/dashboard', [InicioController::class, 'index'])->name('dashboard');

    // Logout
    Route::post('logout', [LoginController::class, 'logout'])->name('logout');

    // Aquí puedes agregar más rutas protegidas



    // Administradores
    Route::get('/listado', [AdministradorController::class, 'listado'])->name('administrador.listado');
    Route::post('/guardar', [AdministradorController::class, 'guardar'])->name('administrador.guardar');
    Route::get('/editar/{id}', [AdministradorController::class, 'editar'])->name('administrador.editar');
    Route::put('/actualizar/{id}', [AdministradorController::class, 'actualizar'])->name('administrador.actualizar');
    Route::get('/mostrar/{id}', [AdministradorController::class, 'mostrar'])->name('administrador.mostrar');
    Route::delete('/eliminar/{id}', [AdministradorController::class, 'eliminar'])->name('administrador.eliminar');
Route::prefix('administrador')->group(function () {
    // Listar secciones
    Route::get('secciones', [SeccionesController::class, 'listado'])->name('secciones.listado');
//mostrar
Route::get('secciones/{id}', [SeccionesController::class, 'mostrar'])->name('secciones.mostrar');
    // Crear
    Route::get('secciones/crear', [SeccionesController::class, 'crear'])->name('secciones.crear');
    Route::post('secciones', [SeccionesController::class, 'store'])->name('secciones.guardar');

    // Editar
    Route::get('secciones/{id}/editar', [SeccionesController::class, 'editar'])->name('secciones.editar');

    //borrar
    Route::get('secciones/{id}/borrar', [SeccionesController::class, 'borrar'])->name('secciones.borrar');

    // Actualizar
    Route::put('secciones/{id}', [SeccionesController::class, 'update'])->name('secciones.update');
});

    // Contenidos
    Route::get('/contenidos', [ContenidosController::class, 'listar'])->name('contenidos.listar');
    Route::get('/contenidos/crear', [ContenidosController::class, 'crear'])->name('contenidos.crear');
    Route::post('/contenidos/guardar', [ContenidosController::class, 'guardar'])->name('contenidos.guardar');
    Route::get('/contenidos/{id}/editar', [ContenidosController::class, 'editar'])->name('contenidos.editar');
    Route::put('/contenidos/{id}/actualizar', [ContenidosController::class, 'actualizar'])->name('contenidos.actualizar');
    Route::get('/contenidos/{id}/mostrar', [ContenidosController::class, 'mostrar'])->name('contenidos.mostrar');
    Route::delete('/contenidos/{id}/borrar', [ContenidosController::class, 'borrar'])->name('contenidos.borrar');

    // Archivos asociados a Contenido
    Route::get('/contenidos/{contenido_id}/archivos', [ArchivoController::class, 'listar'])->name('archivos.listar');
    Route::get('/contenidos/{contenido_id}/archivos/crear', [ArchivoController::class, 'crear'])->name('archivos.crear');
    Route::post('/contenidos/{contenido_id}/archivos/guardar', [ArchivoController::class, 'guardar'])->name('archivos.guardar');
    Route::delete('/archivos/{id}/borrar', [ArchivoController::class, 'borrar'])->name('archivos.borrar');
    Route::get('/archivos/{id}/descargar', [ArchivoController::class, 'descargar'])->name('archivos.descargar');

});