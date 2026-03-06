<?php

namespace App\Http\Controllers\Atenciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente\Paciente;
use App\Models\Paciente\AcudientePaciente;
use App\Models\Atencion\Atencion;
use Illuminate\Support\Facades\Auth;


class AtencionController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        $atenciones = Atencion::with([
            'paciente.acudiente',
            'usuario'
        ])

            ->when($query, function ($q) use ($query) {
                $q->whereHas('usuario', function ($q2) use ($query) {
                    $q2->where('name', 'like', "%{$query}%");
                })
                    ->orWhereHas('paciente', function ($q3) use ($query) {
                        $q3->where('par_nombres', 'like', "%{$query}%");
                    });
            })

            ->when($fecha_inicio, function ($q) use ($fecha_inicio) {
                $q->whereDate('fecha_hora', '>=', $fecha_inicio);
            })

            ->when($fecha_fin, function ($q) use ($fecha_fin) {
                $q->whereDate('fecha_hora', '<=', $fecha_fin);
            })

            ->latest()
            ->get();

        if ($request->ajax()) {
            return view('registros.partials.tablaRegistro', compact('atenciones'))->render();
        }

        return view('registros.index', compact('atenciones'));
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
