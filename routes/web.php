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
Route::view('/panel', 'base.layout')->name('dashboard');
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
    Route::get('/contenidos/crear', [ContenidosController::class, 'crear']);
   Route::post('/contenidos/guardar', [ContenidosController::class, 'guardar'])->name('contenidos.guardar');
    Route::get('/contenidos/listar', [ContenidosController::class, 'listar']);
Route::get('/contenidos/{id}/editar', [ContenidosController::class, 'editar'])->name('contenidos.edit');
Route::put('/contenidos/{id}/actualizar', [ContenidosController::class, 'actualizar'])->name('contenidos.update');
  Route::get('/contenidos/{id}/mostrar', [ContenidosController::class, 'mostrar'])->name('contenidos.mostrar');
    Route::post('/contenidos/{id}/borrar', [ContenidosController::class, 'borrar'])->name('contenidos.borrar');


    // Rutas de Secciones
    Route::get('/secciones/crear', [SeccionesController::class, 'crear']);
    Route::post('/secciones/guardar', [SeccionesController::class, 'guardar']);
    Route::get('/secciones/listar', [SeccionesController::class, 'listar']);
    Route::get('/secciones/{id}/editar', [SeccionesController::class, 'editar']);
    Route::put('/secciones/{id}/actualizar', [SeccionesController::class, 'actualizar'])->name('secciones.update');
    Route::get('/secciones/{id}/mostrar', [SeccionesController::class, 'mostrar']);
    Route::post('/secciones/{id}/borrar', [SeccionesController::class, 'borrar'])->name('secciones.borrar');






Route::get('/', function () {
    return view('welcome');
});
