<?php

use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Aqui es donde se registran las rutas web del modulo de estudiante de la aplicacion.
| Estas rutas seran cargadas por el RouteServiceProvider utilizando el middleware "web"
|
*/

Route::get('estudiantes/{id?}', [EstudianteController::class, 'index'])->name('estudiante.index');
Route::post('estudiantes/crear', [EstudianteController::class, 'Crear'])->name('estudiante.crear');
Route::put('estudiantes/editar', [EstudianteController::class, 'Editar'])->name('estudiante.editar');
Route::delete('estudiantes/eliminar', [EstudianteController::class, 'Eliminar'])->name('estudiante.eliminar');