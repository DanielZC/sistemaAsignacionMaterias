<?php

use App\Http\Controllers\ProfesorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui es donde se registran las rutas web del modulo de profesor de la aplicacion.
| Estas rutas seran cargadas por el RouteServiceProvider utilizando el middleware "web"
|
*/

Route::get('profesores/{id?}', [ProfesorController::class, 'index'])->name('profesor.index');
Route::post('profesores/crear', [ProfesorController::class, 'Crear'])->name('profesor.crear');
Route::put('profesores/editar', [ProfesorController::class, 'Editar'])->name('profesor.editar');
Route::delete('profesores/eliminar', [ProfesorController::class, 'Eliminar'])->name('profesor.eliminar');