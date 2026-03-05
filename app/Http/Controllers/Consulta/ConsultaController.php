<?php

namespace App\Http\Controllers\Consulta;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente\Paciente;

class ConsultaController extends Controller
{
    public function index()
    {
        return view('atenciones.index_atenciones');
    }

    public function buscar(Request $request)
    {
        $request->validate([
            'cedula' => 'required'
        ]);

        // Busca paciente exacto
        $paciente = Paciente::where('par_identificacion', $request->cedula)->first();

        // Retorna a la vista con la variable $paciente
        return view('atenciones.index_atenciones', compact('paciente'));
    }
}
