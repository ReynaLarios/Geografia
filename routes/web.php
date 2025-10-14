<?php


use App\Http\Controllers\SeccionController;
use App\Http\Controllers\ContenidosController;

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
    Route::post('/contenidos/guardar', [ContenidosController::class, 'guardar']);
    Route::get('/contenidos/listar', [ContenidosController::class, 'listar']);
    Route::get('/contenidos/{id}/editar', [ContenidosController::class, 'editar']);
    Route::post('/contenidos/{id}/actualizar', [ContenidosController::class, 'actualizar']);
    Route::get('/contenidos/{id}/mostrar', [ContenidosController::class, 'mostrar']);
    Route::post('/contenidos/{id}/borrar', [ContenidosController::class, 'borrar']);


    // Rutas de Secciones
    Route::get('/secciones/crear', [seccionesController::class, 'crear']);
    Route::post('/secciones/guardar', [seccionesController::class, 'guardar']);
    Route::get('/secciones/listar', [seccionesController::class, 'listar']);
    Route::get('/secciones/{id}/editar', [seccionesController::class, 'editar']);
    Route::post('/secciones/{id}/actualizar', [seccionesController::class, 'actualizar']);
    Route::get('/secciones/{id}/mostrar', [seccionesController::class, 'mostrar']);
    Route::post('/secciones/{id}/borrar', [seccionesController::class, 'borrar']);






Route::get('/', function () {
    return view('welcome');
});
