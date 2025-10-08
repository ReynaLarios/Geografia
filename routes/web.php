<?php

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


Route::get('/', function () {
    return view('welcome');
});
