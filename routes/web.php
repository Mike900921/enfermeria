<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtencionController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Auth\AuthController;



Route::post('/buscar-paciente', [AtencionController::class, 'buscarPaciente'])->name('buscar.paciente');
Route::post('/atenciones', [AtencionController::class, 'store'])->name('atenciones.store');

// Rutas de login (fuera de auth)
Route::get('/login', [AuthController::class, 'index'])->name('login');
Route::post('/login', [AuthController::class, 'login'])->name('login.process');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//rutas del crud de usuarios
//Route::resource('users', UserController::class)->middleware('auth');

// CRUD completo para usuarios
Route::resource('users', UserController::class);

