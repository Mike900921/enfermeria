<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Atenciones\AtencionController;
use App\Http\Controllers\Users\UserController;
use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Consulta\ConsultaController;
use App\Http\Controllers\Caracterizacion\CaracterizacionController;
use App\Http\Controllers\Motivo\MotivoController;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\PacienteExport;

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
    Route::get('/atenciones', [ConsultaController::class, 'index'])->name('atenciones.index_atenciones');





    // Registro de atenciones tabla
    Route::get('/registros', [AtencionController::class, 'index'])->name('registros.index');

    Route::post('/atenciones', [AtencionController::class, 'store'])->name('atenciones.store');
    Route::post('/buscar-paciente', [AtencionController::class, 'buscarPaciente'])->name('buscar.paciente');



    Route::get('/atenciones/create', [AtencionController::class, 'create'])->name('atenciones.create');
    Route::post('/atenciones/store', [AtencionController::class, 'store'])->name('atenciones.store');
    // CRUD de usuarios
    
    //rutas protegidas por el permiso gestionar-usuarios con rol administrador
    Route::middleware(['auth',])->group(function () {
        Route::resource('users', UserController::class);
        Route::post('/users/{id}/restore', [UserController::class, 'restore'])->name('users.restore');
    });


    //RUTA BOTON PARA EXPORTAR PACIENTE A EXCEL -- NO USAR
    //Route::get('/atenciones/export', function () { return Excel::download(new PacienteExport, 'Pacientes.xlsx');})->name('atenciones.export');

    //RUTA PARA IMPRIMIR PDF DE LA ATENCION
    Route::get('/atenciones/crear-pdf/{id}', [AtencionController::class, 'generarPdf'])->name('atencionesPdf');


    //RUTA PARA EXPORTAR PACIENTE A EXCEL CON FILTROS DE BUSQUEDA
    Route::get('/atenciones/export', [AtencionController::class, 'export'])
        ->name('atenciones.export');

    // ruta Estadisticas
    Route::get('/estadisticas', [EstadisticaController::class, 'index'])->name('estadisticas.index');

    // rutas para motivo
    Route::get('/motivos',[MotivoController::class, 'index'])->name('motivos.index');
    Route::get('/buscarMotivos', [MotivoController::class, 'buscar'])->name('motivos.buscar');
    
    //validaciones rutas
        //crear motivo
        Route::post('/motivos', [MotivoController::class, 'store'])->name('motivos.store');
        //editar motivo
        Route::put('/motivos/{id}', [MotivoController::class, 'update'])->name('motivos.update');
        //eliminar motivo (inhabilitar)
        Route::delete('/motivos/destroy/{id}', [MotivoController::class, 'destroy'])->name('motivos.destroy');
        //restaurar motivo
        Route::post('/motivos/restore/{id}', [MotivoController::class, 'restore'])->name('motivos.restore');



    Route::get('/caracterizacion', [CaracterizacionController::class, 'index'])->name('caracterizacion');
});
