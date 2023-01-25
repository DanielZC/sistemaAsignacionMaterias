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

Route::middleware('auth')->get('asignaturas/{id?}', [AsignaturaController::class, 'Index'])->name('asignatura.index');
Route::middleware('auth')->get('asignaturas/detalle/{id?}', [AsignaturaController::class, 'Detalles'])->name('asignatura.detalles');
Route::middleware('auth')->post('asignaturas/crear', [AsignaturaController::class, 'Crear'])->name('asignatura.crear');
Route::middleware('auth')->put('asignaturas/editar', [AsignaturaController::class, 'Editar'])->name('asignatura.editar');
Route::middleware('auth')->delete('asignaturas/eliminar', [AsignaturaController::class, 'Eliminar'])->name('asignatura.eliminar');