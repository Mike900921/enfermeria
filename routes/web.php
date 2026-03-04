<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Atenciones\AtencionController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Consulta\ConsultaController;



Route::post('/buscar-paciente', [AtencionController::class, 'buscarPaciente'])->name('buscar.paciente');
Route::post('/atenciones', [AtencionController::class, 'store'])->name('atenciones.store');

// Rutas de login (fuera de auth)
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');



Route::get('/consulta', [ConsultaController::class, 'index'])->name('consulta.index');
Route::post('/consulta', [ConsultaController::class, 'buscar'])->name('consulta.buscar');

//rutas del crud de usuarios
//Route::resource('users', UserController::class)->middleware('auth');

// CRUD completo para usuarios
Route::resource('users', UserController::class);

