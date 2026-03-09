<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Atenciones\AtencionController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Consulta\ConsultaController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PacienteExport;

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



    Route::get('/atenciones/create', [AtencionController::class, 'create'])->name('atenciones.create');
    Route::post('/atenciones/store', [AtencionController::class, 'store'])->name('atenciones.store');
    // CRUD de usuarios
    Route::resource('users', UserController::class);


    //RUTA BOTON PARA EXPORTAR PACIENTE A EXCEL
    Route::get('/atenciones/export', function () {
        return Excel::download(new PacienteExport, 'Pacientes.xlsx');
    })->name('atenciones.export');
});
