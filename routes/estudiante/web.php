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

Route::middleware('auth')->get('estudiantes/{id?}', [EstudianteController::class, 'index'])->name('estudiante.index');
Route::middleware('auth')->post('estudiantes/crear', [EstudianteController::class, 'Crear'])->name('estudiante.crear');
Route::middleware('auth')->put('estudiantes/editar', [EstudianteController::class, 'Editar'])->name('estudiante.editar');
Route::middleware('auth')->delete('estudiantes/eliminar', [EstudianteController::class, 'Eliminar'])->name('estudiante.eliminar');