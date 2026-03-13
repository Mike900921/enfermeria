<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente\Paciente;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $paciente = null;

        if ($request->cedula) {
            $paciente = Paciente::with('atenciones.usuario', 'ficha.fichapro.programa')
                ->where('par_identificacion', $request->cedula)
                ->first();
        }
        return view('atenciones.index_atenciones', compact('paciente'));
    }


    public function buscar(Request $request)
    {
        $request->validate([
            'cedula' => 'required'
        ]);

        $paciente = Paciente::with('ficha')
            ->where('par_identificacion', $request->cedula)
            ->first();

        return view('atenciones.index_atenciones', compact('paciente'));
    }
}
