<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Paciente;
use App\Models\Atencion;

class AtencionController extends Controller
{
    // 🔎 Buscar paciente por documento
    public function buscarPaciente(Request $request)
    {
        $request->validate([
            'documento' => 'required'
        ]);

        $paciente = Paciente::where('documento', $request->documento)->first();

        if (!$paciente) {
            return back()->with('error', 'Paciente no encontrado');
        }

        return view('atenciones.registrar', compact('paciente'));
    }

    // 💾 Guardar atención
    public function store(Request $request)
    {
        $request->validate([
            'paciente_id' => 'required',
            'motivo' => 'required',
            'fecha_hora' => 'required'
        ]);

        Atencion::create([
            'paciente_id' => $request->paciente_id,
            'usuario_id'  => auth()->id(),
            'fecha_hora'  => $request->fecha_hora,
            'motivo'      => $request->motivo,
            'procedimientos' => $request->procedimientos,
            'observaciones'  => $request->observaciones,
        ]);

        return redirect()->back()->with('success', 'Atención registrada correctamente');
    }
}