<?php

namespace App\Http\Controllers\Atenciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente\Paciente;
use App\Models\Paciente\AcudientePaciente;
use App\Models\Atencion\Atencion;
use Illuminate\Support\Facades\Auth;
use App\Exports\PacienteExport;
use Maatwebsite\Excel\Facades\Excel;


class AtencionController extends Controller
{

    public function index(Request $request)
    {
        $query = $request->input('query');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        $atenciones = Atencion::with(['paciente.acudiente', 'usuario'])

            ->leftJoin('senacdti_seguimientopro.sep_participante as p', 'atenciones.paciente_id', '=', 'p.par_identificacion')
            ->leftJoin('users as u', 'atenciones.user_id', '=', 'u.user_id')

            ->when($query, function ($q) use ($query) {
                $q->where('u.name', 'like', "%{$query}%")
                    ->orWhere('p.par_identificacion', 'like', "%{$query}%")
                    ->orWhere('p.par_nombres', 'like', "%{$query}%")
                    ->orWhere('p.par_apellidos', 'like', "%{$query}%")
                    ->orWhereRaw("CONCAT(p.par_nombres,' ',p.par_apellidos) LIKE ?", ["%{$query}%"]);
            })

            ->when($fecha_inicio, function ($q) use ($fecha_inicio) {
                $q->whereDate('fecha_hora', '>=', $fecha_inicio);
            })

            ->when($fecha_fin, function ($q) use ($fecha_fin) {
                $q->whereDate('fecha_hora', '<=', $fecha_fin);
            })

            ->select('atenciones.*')
            ->orderBy('fecha_hora', 'desc')
            ->paginate(7)->withQueryString();


        if ($request->ajax()) {
            return view('registros.partials.tablaRegistro', compact('atenciones'))->render();
        }

        return view('registros.index', compact('atenciones'));
    }

    // Método para exportar a Excel
    public function export(Request $request)
    {
        $query = $request->input('query');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');

        $atenciones = Atencion::with(['paciente.acudiente', 'usuario'])
            ->leftJoin('senacdti_seguimientopro.sep_participante as p', 'atenciones.paciente_id', '=', 'p.par_identificacion')
            ->leftJoin('users as u', 'atenciones.user_id', '=', 'u.user_id')
            ->when($query, function ($q) use ($query) {
                $q->where(function ($sub) use ($query) {
                    $sub->where('u.name', 'like', "%{$query}%")
                        ->orWhere('p.par_identificacion', 'like', "%{$query}%")
                        ->orWhere('p.par_nombres', 'like', "%{$query}%")
                        ->orWhere('p.par_apellidos', 'like', "%{$query}%")
                        ->orWhereRaw("CONCAT(p.par_nombres,' ',p.par_apellidos) LIKE ?", ["%{$query}%"]);
                });
            })
            ->when($fecha_inicio, fn($q) => $q->whereDate('fecha_hora', '>=', $fecha_inicio))
            ->when($fecha_fin, fn($q) => $q->whereDate('fecha_hora', '<=', $fecha_fin))
            ->select('atenciones.*')
            ->orderBy('fecha_hora', 'desc')
            ->get();

        return Excel::download(new PacienteExport($atenciones), 'pacientes.xlsx');
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
        //return view('atenciones.index_atenciones', compact('paciente'));
    }


    public function store(Request $request)
    {
        $data = $request->validate([
            'paciente_id' => 'required',
            'motivo' => 'required',
            'ficha_id' => 'nullable',
            'fecha_hora' => 'required',
            'procedimientos' => 'nullable',
            'observaciones' => 'nullable'
        ]);

        // valor por defecto
        $data['ficha_id'] = is_numeric($data['ficha_id']) ? $data['ficha_id'] : 1;

        $data['user_id'] = Auth::id();
        $paciente = Paciente::find($request->paciente_id);

        Atencion::create($data);

        //return redirect()->route('registros.index')->with('success', 'El paciente fue registrado correctamente.');
        return view('atenciones.index_atenciones', compact('paciente'))->with('success', 'Atención registrada correctamente.');
    }
}
