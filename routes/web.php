<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AtencionController;
use App\Http\Controllers\UserController;


Route::get('/', function () {
    return view('welcome');
});



Route::post('/buscar-paciente', [AtencionController::class, 'buscarPaciente'])->name('buscar.paciente');
Route::post('/atenciones', [AtencionController::class, 'store'])->name('atenciones.store');

//rutas del crud de usuarios
//Route::resource('users', UserController::class)->middleware('auth');