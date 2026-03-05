<?php

namespace App\Http\Controllers\Atenciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente\Paciente;
use App\Models\Atencion\Atencion;
use Illuminate\Support\Facades\Auth;

class AtencionController extends Controller
{

    public function index()
    {
        $atenciones = Atencion::with('paciente', 'usuario')->get();
        $paciente = Paciente::all();
        return view('registros.index', compact('atenciones', 'paciente'));
    }

    // 🔎 Buscar paciente por documento
    public function buscarPaciente(Request $request)
    {
        $request->validate([
            'cedula' => 'required'
        ]);

        $paciente = Paciente::with('atenciones.usuario')
            ->where('par_identificacion', $request->cedula)
            ->first();

        if (!$paciente) {
            return back()->with('error', 'Paciente no encontrado');
        }

        return view('atenciones.registrar', compact('paciente'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required',
            'motivo' => 'required',
            'fecha_hora' => 'required'
        ]);

        Atencion::create([
            'paciente_id' => $request->paciente_id,
            'usuario_id' => Auth::id(),
            'fecha_hora'  => $request->fecha_hora,
            'motivo'      => $request->motivo,
            'procedimientos' => $request->procedimientos,
            'observaciones'  => $request->observaciones,
        ]);

        return redirect()->back()->with('success', 'Atención registrada correctamente');
    }
}
