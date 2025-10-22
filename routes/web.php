<?php


use App\Http\Controllers\SeccionController;
use App\Http\Controllers\ContenidosController;
use App\Http\Controllers\SeccionesController;

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
// Rutas del Panel
// Rutas del Panel
Route::view('/', 'base.layout')->name('dashboard');
Route::view('/inicio', 'Inicio.Inicio')->name('dashboard');
Route::view('/mision', 'Mision.Mision')->name('dashboard');
Route::view('/vision', 'Vision.Vision')->name('dashboard');
Route::view('/objetivos', 'Objetivos.Objetivos')->name('dashboard');
Route::view('/licenciatura', 'Licenciatura.Licenciatura')->name('dashboard');
Route::view('/conoce', 'conoce.conoce')->name('dashboard');
Route::view('/videoteca', 'videoteca.videoteca')->name('dashboard');
Route::view('/videoteca/recientes', 'videoteca.recientes')->name('dashboard');
Route::view('/videoteca/populares', 'videoteca.varios')->name('dashboard');
Route::view('/alumnos', 'alumnos.alumnos')->name('dashboard');
Route::view('/acerca', 'acerca.acerca')->name('dashboard');
Route::view('/horarios', 'horarios.horarios')->name('dashboard');
Route::view('/cursos', 'cursos.cursos')->name('dashboard');
Route::view('/normatividad', 'normatividad.normatividad')->name('dashboard');
Route::view('/egresados', 'egresados.egresados')->name('dashboard');
Route::view('/cont', 'Formularios.formularioscont')->name('dashboard');
Route::view('/secc', 'Formularios.formulariosecc')->name('dashboard');


// Rutas de Contenidos
    Route::get('/contenidos/crear', [ContenidosController::class, 'crear'])->name('contenidos.crear');
    Route::get('/contenidos/listar', [ContenidosController::class, 'listar']);
   Route::post('/contenidos/guardar', [ContenidosController::class, 'guardar'])->name('contenidos.guardar');
    Route::get('/contenidos/listar', [ContenidosController::class, 'listar'])->name('contenidos.listar');
Route::get('/contenidos/{id}/editar', [ContenidosController::class, 'editar'])->name('contenidos.edit');
Route::put('/contenidos/{id}/actualizar', [ContenidosController::class, 'actualizar'])->name('contenidos.update');
  Route::get('/contenidos/{id}/mostrar', [ContenidosController::class, 'mostrar'])->name('contenidos.{id}.mostrar');
Route::delete('/contenidos/{id}/borrar', [ContenidosController::class, 'borrar'])->name('contenidos.{id}.borrar');


    // Rutas de Secciones
    Route::get('/secciones/crear', [SeccionesController::class, 'crear'])->name('secciones.crear');
    Route::post('/secciones/guardar', [SeccionesController::class, 'guardar'])->name('secciones.guardar');
    Route::get('/secciones/listar', [SeccionesController::class, 'listar'])->name('secciones.listar');
    Route::get('/secciones/{id}/editar', [SeccionesController::class, 'editar'])->name('secciones.{id}.editar');
    Route::put('/secciones/{id}/actualizar', [SeccionesController::class, 'actualizar'])->name('secciones.update');
   Route::get('/secciones/{id}/mostrar', [SeccionesController::class, 'mostrar'])->name('secciones.{id}.mostrar');
   Route::delete('/secciones/{id}/borrar', [SeccionesController::class, 'borrar'])->name('secciones.{id}.borrar');

   
   Route::get('/contenidos/{contenido_id}/archivos', [ArchivoController::class, 'listar'])->name('archivos.listar');
Route::get('/contenidos/{contenido_id}/archivos/crear', [ArchivoController::class, 'crear'])->name('archivos.crear');
Route::post('/contenidos/{contenido_id}/archivos/guardar', [ArchivoController::class, 'guardar'])->name('archivos.guardar');
Route::delete('/archivos/{id}/borrar', [ArchivoController::class, 'borrar'])->name('archivos.borrar');
Route::get('/archivos/{id}/descargar', [ArchivoController::class, 'descargar'])->name('archivos.descargar');


// Rutas de Administradores
    Route::prefix('administradores')->group(function () {
        Route::get('/crear', [AdministradorController::class, 'crear'])->name('administradores.crear');
        Route::post('/guardar', [AdministradorController::class, 'guardar'])->name('administradores.guardar');
        Route::get('/listar', [AdministradorController::class, 'listar'])->name('administradores.listar');
        Route::get('/{id}/editar', [AdministradorController::class, 'editar'])->name('administradores.editar');
        Route::post('/{id}/actualizar', [AdministradorController::class, 'actualizar'])->name('administradores.actualizar');
        Route::post('/{id}/borrar', [AdministradorController::class, 'borrar'])->name('administradores.borrar');
    });


use App\Http\Controllers\InicioController;

Route::resource('inicio', InicioController::class);








