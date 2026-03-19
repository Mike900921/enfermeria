<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente\Paciente;
use App\Models\Motivo\Motivo;

class ConsultaController extends Controller
{
    public function index(Request $request)
    {
        $paciente = null;
        $motivos = Motivo::all();

        if ($request->cedula) {
            $paciente = Paciente::with('atenciones.usuario', 'ficha.fichapro.programa')
                ->where('par_identificacion', $request->cedula)
                ->first();
        }
        //return view('atenciones.index_atenciones', compact('paciente'));
        return view('atenciones.index_atenciones', compact('paciente', 'motivos'));
    }


    public function buscar(Request $request)
    {
        $request->validate([
            'cedula' => 'required'
        ]);

        $paciente = Paciente::with('ficha')
            ->where('par_identificacion', $request->cedula)
            ->first();

        $motivos = Motivo::all(); 

        return view('atenciones.index_atenciones', compact('paciente', 'motivos'));
        //return view('atenciones.index_atenciones', compact('paciente'));
    }
}
