<?php

use App\Http\Controllers\ProfesorController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Aqui es donde se registran las rutas api del modulo de profesor de la aplicacion.
| Estas rutas seran cargadas por el RouteServiceProvider utilizando el middleware "api"
|
*/

Route::get('profesores/ver/{id}', [ProfesorController::class, 'Ver']);
