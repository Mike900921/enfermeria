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
            $paciente = Paciente::with([
                'atenciones' => function ($query) {
                    $query->orderBy('fecha_hora', 'desc'); // o 'created_at' si la tienes
                },
                'atenciones.usuario',
                'ficha.fichapro.programa'
            ])
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

        $paciente = Paciente::with([
            'atenciones' => function ($query) {
                $query->orderBy('fecha_hora', 'desc');
            },
            'atenciones.usuario',
            'ficha.fichapro.programa'
        ])
            ->where('par_identificacion', $request->cedula)
            ->first();

        //Si no existe el paciente
        if (!$paciente) {
            return back()->with('error', 'La cédula ingresada no existe en la base de datos');
        }

        $motivos = Motivo::all();

        return view('atenciones.index_atenciones', compact('paciente', 'motivos'));
    }
}
