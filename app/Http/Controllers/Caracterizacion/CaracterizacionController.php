<?php

namespace App\Http\Controllers\Caracterizacion;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class CaracterizacionController extends Controller
{
    public function index()
    {
         if (Gate::denies('admisnitradorEnfermeria')) {
            return redirect()->route('consulta.index')
                ->with('error', 'No tienes permisos para acceder');
        }
        return view('caracterizacion/caracterizacion');
    }
}