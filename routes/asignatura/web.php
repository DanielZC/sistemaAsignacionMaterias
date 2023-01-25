<?php

use App\Http\Controllers\AsignaturaController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| WEB Routes
|--------------------------------------------------------------------------
|
| Aqui es donde se registran las rutas web del modulo de asignatura de la aplicacion.
| Estas rutas seran cargadas por el RouteServiceProvider utilizando el middleware "api"
|
*/

Route::get('asignaturas/{id?}', [AsignaturaController::class, 'Index'])->name('asignatura.index');
Route::get('asignaturas/detalle/{id?}', [AsignaturaController::class, 'Detalles'])->name('asignatura.detalles');
Route::post('asignaturas/crear', [AsignaturaController::class, 'Crear'])->name('asignatura.crear');
Route::put('asignaturas/editar', [AsignaturaController::class, 'Editar'])->name('asignatura.editar');
Route::delete('asignaturas/eliminar', [AsignaturaController::class, 'Eliminar'])->name('asignatura.eliminar');