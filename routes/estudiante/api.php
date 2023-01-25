<?php

use App\Http\Controllers\EstudianteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui es donde se registran las rutas api del modulo de estudiante de la aplicacion.
| Estas rutas seran cargadas por el RouteServiceProvider utilizando el middleware "api"
|
*/

Route::get('estudiantes/ver/{id}', [EstudianteController::class, 'Ver']);
