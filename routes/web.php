<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Atenciones\AtencionController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Consulta\ConsultaController;
use App\Http\Controllers\Estadisticas\EstadisticaController;


/*
|--------------------------------------------------------------------------
| Rutas Públicas (login/logout)
|--------------------------------------------------------------------------
*/

// Login
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');

// Logout (requiere autenticación)
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


/*
|--------------------------------------------------------------------------
| Rutas protegidas por middleware auth
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {

    // Dashboard / Consulta aprendiz
    Route::get('/consulta', [ConsultaController::class, 'index'])->name('consulta.index');
    Route::post('/consulta', [ConsultaController::class, 'buscar'])->name('consulta.buscar');

    // Registro de atenciones
    Route::get('/registros', [AtencionController::class, 'index'])->name('registros.index');
    Route::post('/atenciones', [AtencionController::class, 'store'])->name('atenciones.store');
    Route::post('/buscar-paciente', [AtencionController::class, 'buscarPaciente'])->name('buscar.paciente');

    // CRUD de usuarios
    Route::resource('users', UserController::class);

    //estadisticas
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');
});
