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

        $paciente = Paciente::where('numero_documento', $request->cedula)
            ->with('atenciones.usuario')
            ->first();

        return view('atenciones.index_atenciones', compact('paciente'));
    }
}
