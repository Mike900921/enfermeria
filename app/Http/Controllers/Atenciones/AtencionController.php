<?php

namespace App\Http\Controllers\Atenciones;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Paciente\Paciente;
use App\Models\Paciente\AcudientePaciente;
use App\Models\Atencion\Atencion;
use App\Models\Motivo\Motivo;
use Illuminate\Support\Facades\Auth;
use App\Exports\PacienteExport;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Collection;


class AtencionController extends Controller
{
    public function index(Request $request)
    {
        $query = trim($request->input('query'));
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $tipo_documento = trim((string) $request->input('tipo_documento'));
        $filtro_edad = $request->input('filtro_edad');
        $motivos = Cache::remember('motivos', 3600, function () {
            return Motivo::all();
        });

        $tiposDocumentos = $this->getTiposDocumento()
            ->map(function ($row) {
                $valor = $row->apr_documento_id ?? $row->id ?? $row->sigla;
                $texto = $row->nom_tipo_documento ?? $row->nombre ?? $row->sigla ?? $valor;
                $sigla = $row->sigla ?? $texto;

                return [
                    'valor' => (string) $valor,
                    'texto' => (string) $texto,
                    'sigla' => (string) $sigla,
                ];
            })
            ->filter(fn($item) => !empty($item['valor']))
            ->unique('valor')
            ->values();

        $tiposDocumentoPorId = $tiposDocumentos
            ->pluck('sigla', 'valor')
            ->toArray();

        // IDs por búsqueda textual (nombre, apellido o documento)
        $pacienteIdsBusqueda = collect();
        if (!empty(trim($query))) {
            $pacienteIdsBusqueda = \App\Models\Paciente\Paciente::on('senacdti_seguimientopro')
                ->whereRaw("CONCAT(par_nombres, ' ', par_apellidos) LIKE ?", ["%{$query}%"])
                ->orWhere('par_nombres', 'like', "{$query}%")
                ->orWhere('par_apellidos', 'like', "{$query}%")
                ->orWhere('par_identificacion', 'like', "{$query}%")
                ->pluck('par_identificacion');
        }

        // IDs por filtros de paciente (tipo de documento / edad)
        $pacienteIdsFiltro = null;
        if (!empty($tipo_documento) || in_array($filtro_edad, ['menor_18', 'mayor_18'], true)) {
            $pacientesFiltrados = \App\Models\Paciente\Paciente::on('senacdti_seguimientopro')
                ->when(!empty($tipo_documento), function ($q) use ($tipo_documento) {
                    $q->where('par_tipo_doc', $tipo_documento);
                })
                ->when(in_array($filtro_edad, ['menor_18', 'mayor_18'], true), function ($q) use ($filtro_edad) {
                    $fechaCorte = now()->subYears(18)->toDateString();
                    $q->whereNotNull('par_fec_nacimiento');

                    if ($filtro_edad === 'menor_18') {
                        $q->whereDate('par_fec_nacimiento', '>', $fechaCorte);
                    }

                    if ($filtro_edad === 'mayor_18') {
                        $q->whereDate('par_fec_nacimiento', '<=', $fechaCorte);
                    }
                });

            $pacienteIdsFiltro = $pacientesFiltrados->pluck('par_identificacion');
        }

        // Tipo de búsqueda: 'usuario' por defecto
        $atenciones = Atencion::with(['paciente.acudiente', 'usuario', 'paciente.caracterizacion_apr.resultados_apr'])
            ->when(!empty($query), function ($q) use ($query, $pacienteIdsBusqueda) {
                $q->where(function ($sub) use ($query, $pacienteIdsBusqueda) {
                    $sub->whereHas('usuario', function ($q1) use ($query) {
                        $q1->whereRaw("CONCAT(name, ' ', last_name) LIKE ?", ["%{$query}%"]);
                    })
                        ->orWhereIn('paciente_id', $pacienteIdsBusqueda);
                });
            })

            ->when($fecha_inicio, function ($q) use ($fecha_inicio) {
                $q->whereDate('fecha_hora', '>=', $fecha_inicio);
            })
            ->when($fecha_fin, function ($q) use ($fecha_fin) {
                $q->whereDate('fecha_hora', '<=', $fecha_fin);
            })
            ->when($pacienteIdsFiltro !== null, function ($q) use ($pacienteIdsFiltro) {
                $q->whereIn('paciente_id', $pacienteIdsFiltro);
            })
            ->select('atenciones.*')
            ->orderBy('fecha_hora', 'desc')

            ->paginate(10)
            ->withQueryString();



        if ($request->ajax()) {
            // return view('registros.partials.tablaRegistro', compact('atenciones'))->render();
            return view('registros.partials.tablaRegistro', compact('atenciones', 'motivos', 'tiposDocumentoPorId'))->render();
        }


        return view('registros.index', compact('atenciones', 'motivos', 'tiposDocumentos', 'tiposDocumentoPorId'));
    }

    protected function getTiposDocumento(): Collection
    {
        return DB::connection('senacdti_seguimientopro')
            ->table('sep_apr_documento')
            ->orderBy('nom_tipo_documento')
            ->get();
    }

    //metodo para generar PDF de la atención
    public function generarPdf($id)
    {
        $atencion = Atencion::with(['paciente', 'usuario'])->findOrFail($id);
        $motivos = Motivo::all();
        // Pasamos los datos a la vista del PDF
        $pdf = Pdf::loadView('pdf.ordenPdf', compact('atencion', 'motivos'));

        // Configuramos el papel
        $pdf->setPaper('letter', 'portrait');
        // Retornamos el stream para que se abra en una pestaña nueva
        return $pdf->stream('Atencion_' . $atencion->id . '.pdf');
    }


    // Método para exportar a Excel con filtros de búsqueda y fecha
    public function export(Request $request)
    {
        $query = $request->input('query');
        $fecha_inicio = $request->input('fecha_inicio');
        $fecha_fin = $request->input('fecha_fin');
        $tipo_documento = trim((string) $request->input('tipo_documento'));
        $filtro_edad = $request->input('filtro_edad');

        $motivos = Cache::remember('motivos', 3600, function () {
            return Motivo::all();
        });

        // IDs por búsqueda textual (nombre, apellido o documento)
        $pacienteIdsBusqueda = collect();
        if (!empty(trim($query))) {
            $pacienteIdsBusqueda = \App\Models\Paciente\Paciente::on('senacdti_seguimientopro')
                ->where('par_nombres', 'like', "{$query}%")
                ->orWhere('par_apellidos', 'like', "{$query}%")
                ->orWhere('par_identificacion', 'like', "{$query}%")
                ->pluck('par_identificacion');
        }

        // IDs por filtros de paciente (tipo de documento / edad)
        $pacienteIdsFiltro = null;
        if (!empty($tipo_documento) || in_array($filtro_edad, ['menor_18', 'mayor_18'], true)) {
            $pacientesFiltrados = \App\Models\Paciente\Paciente::on('senacdti_seguimientopro')
                ->when(!empty($tipo_documento), function ($q) use ($tipo_documento) {
                    $q->where('par_tipo_doc', $tipo_documento);
                })
                ->when(in_array($filtro_edad, ['menor_18', 'mayor_18'], true), function ($q) use ($filtro_edad) {
                    $fechaCorte = now()->subYears(18)->toDateString();
                    $q->whereNotNull('par_fec_nacimiento');

                    if ($filtro_edad === 'menor_18') {
                        $q->whereDate('par_fec_nacimiento', '>', $fechaCorte);
                    }

                    if ($filtro_edad === 'mayor_18') {
                        $q->whereDate('par_fec_nacimiento', '<=', $fechaCorte);
                    }
                });

            $pacienteIdsFiltro = $pacientesFiltrados->pluck('par_identificacion');
        }

        // Tipo de búsqueda: 'usuario' por defecto
        $atenciones = Atencion::with(['paciente.acudiente', 'usuario', 'ficha.fichapro.programa'])
            ->when(!empty($query), function ($q) use ($query, $pacienteIdsBusqueda) {
                $q->where(function ($sub) use ($query, $pacienteIdsBusqueda) {
                    $sub->whereHas('usuario', function ($q1) use ($query) {
                        $q1->whereRaw("CONCAT(name, ' ', last_name) LIKE ?", ["%{$query}%"]);
                    })
                        ->orWhereIn('paciente_id', $pacienteIdsBusqueda);
                });
            })
            ->when($fecha_inicio, fn($q) => $q->whereDate('fecha_hora', '>=', $fecha_inicio))
            ->when($fecha_fin, fn($q) => $q->whereDate('fecha_hora', '<=', $fecha_fin))
            ->when($pacienteIdsFiltro !== null, function ($q) use ($pacienteIdsFiltro) {
                $q->whereIn('paciente_id', $pacienteIdsFiltro);
            })
            ->select('atenciones.*')
            ->orderBy('fecha_hora', 'desc')
            ->get();

        return Excel::download(new PacienteExport($atenciones), 'Enfermería_SenaCDTI.xlsx');
    }

    public function create()
    {
        $pacientes = Paciente::all();
        return view('atenciones.create_atenciones', compact('pacientes'));
    }

    //  Buscar paciente por documento
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

        $motivos = Motivo::all();
        return view('atenciones.registrar', compact('paciente', 'motivos'));
        //return view('atenciones.registrar', compact('paciente'));
        //return view('atenciones.index_atenciones', compact('paciente'));
    }

    // Registrar atención
    public function store(Request $request)
    {
        $data = $request->validate([
            'paciente_id' => 'required',
            //'motivo' => 'required|max:255',
            'motivo_id' => 'required|exists:motivos,id',
            'ficha_id' => 'nullable',
            'fecha_hora' => 'required',
            'procedimientos' => 'nullable',
            'observaciones' => 'nullable'
        ], [
            'paciente_id.required' => 'El campo paciente es obligatorio.',
            //'motivo.required' => 'El campo motivo es obligatorio.',
            'motivo_id.required' => 'El campo motivo es obligatorio.',
            'motivo.max' => 'El campo motivo debe tener entre 2 y 255 caracteres.',
            'fecha_hora.required' => 'El campo fecha y hora es obligatorio.'
        ]);

        $data['ficha_id'] = is_numeric($data['ficha_id']) ? $data['ficha_id'] : 1;
        $data['user_id'] = Auth::id();

        // ❗ quitar motivo_id del insert
        $atencion = Atencion::create(collect($data)->except('motivo_id')->toArray());

        if ($request->has('motivo_id')) {
            $atencion->motivo()->sync($request->motivo_id);
        }

        return redirect()
            ->route('atenciones.index_atenciones', ['cedula' => $request->paciente_id])
            ->with('success', 'Atención registrada correctamente.');
    }
}
