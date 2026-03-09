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

        $atenciones = Atencion::with(['paciente.acudiente', 'usuario'])

            ->leftJoin('senacdti_seguimientopro.sep_participante as p', 'atenciones.paciente_id', '=', 'p.par_identificacion')
            ->leftJoin('users as u', 'atenciones.usuario_id', '=', 'u.id')

            ->when($query, function ($q) use ($query) {
                $q->where('u.name', 'like', "%{$query}%")
                    ->orWhere('p.par_identificacion', 'like', "%{$query}%")
                    ->orWhere('p.par_nombres', 'like', "%{$query}%");
            })

            ->when($fecha_inicio, function ($q) use ($fecha_inicio) {
                $q->whereDate('fecha_hora', '>=', $fecha_inicio);
            })

            ->when($fecha_fin, function ($q) use ($fecha_fin) {
                $q->whereDate('fecha_hora', '<=', $fecha_fin);
            })

            ->select('atenciones.*')
            ->orderBy('fecha_hora', 'desc')
            ->get();


        if ($request->ajax()) {
            return view('registros.partials.tablaRegistro', compact('atenciones'))->render();
        }

        return view('registros.index', compact('atenciones'));
    }

    public function create()
    {
        $pacientes = Paciente::all();
        return view('atenciones.create_atenciones', compact('pacientes'));
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
