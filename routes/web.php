<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtencionController;
use App\Http\Controllers\Users\UserController;


Route::post('/buscar-paciente', [AtencionController::class, 'buscarPaciente'])->name('buscar.paciente');
Route::post('/atenciones', [AtencionController::class, 'store'])->name('atenciones.store');

// CRUD completo para usuarios
Route::resource('users', UserController::class);
