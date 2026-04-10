<?php


namespace App\Http\Controllers\Estadisticas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Atencion\Atencion;
use App\Models\Ficha\Ficha;
use App\Models\Ficha\FichaPro;
use App\Models\Programa\Programa;
use App\Models\Motivo\Motivo;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;

class EstadisticaController extends Controller
{
    public function index(Request $request)
    {

    // Validación manual
        if (Gate::denies('admisnitradorEnfermeria')) {
            return redirect()->route('consulta.index')
                ->with('error', 'No tienes permisos para acceder');
        }
        //--------------------------------------validaciones de los inputs de fecha -------------------------------------------------------------
        $request->validate([
            'fecha_inicio' => 'nullable|date|required_with:fecha_fin',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ], [
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_inicio.required_with' => 'La fecha de inicio es requerida cuando se proporciona la fecha fin.',
            'fecha_fin.after_or_equal' => 'La fecha fin debe ser igual o posterior a la fecha de inicio.',
        ]);


        $ver = $request->get('ver', 'ficha');

        /*if ($request->filled('buscador')) {
            if (is_numeric($busqueda)) {
                // Buscamos si existe una ficha con ese número exacto
                $existeFicha = \App\Models\Ficha\Ficha::where('fic_numero', $busqueda)->exists();

                if ($existeFicha) {
                    $ver = 'ficha';
                } else {
                    // Si no es ficha, pero es número, lo tratamos como paciente
                    $ver = 'pacientes';
                }
            } else {
                $ver = 'programa';
            }
        }*/


        //--------------------consulta base para las estadísticas, con joins para traer la información relacionada de fichas, programas, aprendices y coordinadores--------------------------------

        // Consulta Base con filtros por conexión
        $query = $this->buildBaseAtencionQuery($request);

        // Agrupación por Vista
        if ($ver === 'programa') {
            $topData = $this->buildTopDataPorPrograma($query);
        } elseif ($ver === 'pacientes') {
            $topData = $query->select('paciente_id', 'ficha_id', DB::raw('count(*) as total'))
                ->groupBy('paciente_id', 'ficha_id');
        } elseif ($ver === 'motivos') {
            $topData = $query->join('atencion_motivo', 'atencion_motivo.atencion_id', '=', 'atenciones.id')
                ->join('motivos', 'motivos.id', '=', 'atencion_motivo.motivo_id')
                ->select('motivos.id as motivo_id', 'motivos.motivo', DB::raw('count(*) as total'))
                ->groupBy('motivos.id', 'motivos.motivo');
        } else {
            $topData = $query->select('ficha_id', DB::raw('count(*) as total'))
                ->groupBy('ficha_id');
        }

        // Ejecución (Traemos los 10 mejores)
        if ($ver !== 'programa') {
            $topData = $topData->orderBy('total', 'desc')->limit(10)->get();
        }

        // Carga de Relaciones (Aquí es donde recuperamos los nombres para los 10 resultados)
        $programas = null;
        $coordinadores = null;
        if ($ver === 'programa') {
            $programas = Programa::whereIn('prog_codigo', $topData->pluck('prog_codigo'))->get()->keyBy('prog_codigo');
            $coordinadores = DB::connection('senacdti_seguimientopro')->table('sep_ficha as f')
                ->join('sep_participante as p', 'f.par_identificacion_coordinador', '=', 'p.par_identificacion')
                ->whereIn('f.prog_codigo', $topData->pluck('prog_codigo'))
                ->select('f.prog_codigo', 'p.par_nombres', 'p.par_apellidos')
                ->get()
                ->groupBy('prog_codigo')
                ->map(function ($group) {
                    return $group->first();
                });
        } elseif ($ver === 'pacientes' || $ver === 'ficha') {
            $topData->load(['paciente', 'ficha.fichapro.programa', 'ficha.fichapro.coordinador']);
        }


        // Mapeo de datos para la Vista (Llenamos las variables que usa tu Blade)
        $topData->transform(function ($item) use ($ver, $programas, $coordinadores) {
            if ($ver === 'programa') {
                $programa = $programas[$item->prog_codigo] ?? null;
                $item->etiqueta = $programa ? $programa->prog_nombre : 'N/A';
                $coordinador = $coordinadores[$item->prog_codigo] ?? null;
                $item->nombre_coord = $coordinador ? $coordinador->par_nombres : 'N/A';
                $item->apellido_coord = $coordinador ? $coordinador->par_apellidos : 'N/A';
            } elseif ($ver === 'pacientes') {
                $item->etiqueta = $item->paciente
                    ? ($item->paciente->par_nombres . ' ' . $item->paciente->par_apellidos)
                    : "ID: {$item->paciente_id}";
                $item->numeroDocumento = $item->paciente_id;
                $item->fichaPaciente = $item->ficha_id ?? 'N/A'; 
            } elseif ($ver === 'motivos') {
                $item->etiqueta = $item->motivo;
            } else {
                $item->etiqueta = $item->ficha_id;
                $item->programa = $item->ficha->fichapro->programa->prog_nombre ?? 'Sin Programa';
            }
            return $item;
        });


        //  Preparar Gráfico
        $labels = $topData->pluck('etiqueta');
        $values = $topData->pluck('total');

        return view('estadisticas.index', compact('topData', 'labels', 'values', 'ver'));
    }

    public function export(Request $request)
    {
        // Validaciones de fecha
        $request->validate([
            'fecha_inicio' => 'nullable|date|required_with:fecha_fin',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ], [
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_inicio.required_with' => 'La fecha de inicio es requerida cuando se proporciona la fecha fin.',
            'fecha_fin.after_or_equal' => 'La fecha fin debe ser igual o posterior a la fecha de inicio.',
        ]);

        $ver = $request->get('ver', 'ficha');

        // Consulta Base con Filtros
        $query = $this->buildBaseAtencionQuery($request);

        // Agrupación por Vista (Top 10 solo)
        if ($ver === 'programa') {
            $topData = $this->buildTopDataPorPrograma($query);
        } elseif ($ver === 'pacientes') {
            $topData = $query->select('paciente_id', 'ficha_id', DB::raw('count(*) as total'))
                ->groupBy('paciente_id', 'ficha_id')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();
        } elseif ($ver === 'motivos') {
            $topData = $query->join('atencion_motivo', 'atencion_motivo.atencion_id', '=', 'atenciones.id')
                ->join('motivos', 'motivos.id', '=', 'atencion_motivo.motivo_id')
                ->select('motivos.id as motivo_id', 'motivos.motivo', DB::raw('count(*) as total'))
                ->groupBy('motivos.id', 'motivos.motivo')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();
        } else {
            $topData = $query->select('ficha_id', DB::raw('count(*) as total'))
                ->groupBy('ficha_id')
                ->orderBy('total', 'desc')
                ->limit(10)
                ->get();
        }

        // Carga de Relaciones
        $programas = null;
        $coordinadores = null;
        if ($ver === 'programa') {
            $programas = Programa::whereIn('prog_codigo', $topData->pluck('prog_codigo'))->get()->keyBy('prog_codigo');
            $coordinadores = DB::connection('senacdti_seguimientopro')->table('sep_ficha as f')
                ->join('sep_participante as p', 'f.par_identificacion_coordinador', '=', 'p.par_identificacion')
                ->whereIn('f.prog_codigo', $topData->pluck('prog_codigo'))
                ->select('f.prog_codigo', 'p.par_nombres', 'p.par_apellidos')
                ->get()
                ->groupBy('prog_codigo')
                ->map(function ($group) {
                    return $group->first();
                });
        } elseif ($ver === 'pacientes' || $ver === 'ficha') {
            $topData->load(['paciente', 'ficha.fichapro.programa', 'ficha.fichapro.coordinador']);
        }

        // Mapeo de datos
        $topData->transform(function ($item) use ($ver, $programas, $coordinadores) {
            if ($ver === 'programa') {
                $programa = $programas[$item->prog_codigo] ?? null;
                $item->etiqueta = $programa ? $programa->prog_nombre : 'N/A';
                $coordinador = $coordinadores[$item->prog_codigo] ?? null;
                $item->nombre_coord = $coordinador ? $coordinador->par_nombres : 'N/A';
                $item->apellido_coord = $coordinador ? $coordinador->par_apellidos : 'N/A';
            } elseif ($ver === 'pacientes') {
                $item->etiqueta = $item->paciente
                    ? ($item->paciente->par_nombres . ' ' . $item->paciente->par_apellidos)
                    : "ID: {$item->paciente_id}";
                $item->numeroDocumento = $item->paciente_id;
                $item->fichaPaciente = $item->ficha_id ?? 'N/A';
            } elseif ($ver === 'motivos') {
                $item->etiqueta = $item->motivo;
            } else {
                $item->etiqueta = $item->ficha_id;
                $item->programa = $item->ficha->fichapro->programa->prog_nombre ?? 'Sin Programa';
            }
            return $item;
        });

        // Generar Excel
        return Excel::download(new \App\Exports\EstadisticasExport($topData, $ver), 'estadisticas.xlsx');
    }

    private function buildBaseAtencionQuery(Request $request)
    {
        $terminosBusqueda = collect([
            $request->input('buscador'),
            $request->input('buscador_dos'),
        ])->map(function ($term) {
            return trim((string) $term);
        })->filter()->values();

        $fichasPorProgramaPorTermino = [];
        foreach ($terminosBusqueda as $termino) {
            if (!is_numeric($termino)) {
                $fichasPorProgramaPorTermino[$termino] = DB::connection('senacdti_seguimientopro')
                    ->table('sep_ficha as f_ext')
                    ->join('sep_programa as p_ext', 'f_ext.prog_codigo', '=', 'p_ext.prog_codigo')
                    ->where('p_ext.prog_nombre', 'like', "%{$termino}%")
                    ->pluck('f_ext.fic_numero');
            }
        }

        return Atencion::query()
            ->when($request->filled('fecha_inicio'), function ($q) use ($request) {
                $q->whereDate('atenciones.fecha_hora', '>=', $request->fecha_inicio);
            })
            ->when($request->filled('fecha_fin'), function ($q) use ($request) {
                $q->whereDate('atenciones.fecha_hora', '<=', $request->fecha_fin);
            })
            ->when($terminosBusqueda->isNotEmpty(), function ($q) use ($terminosBusqueda, $fichasPorProgramaPorTermino) {
                foreach ($terminosBusqueda as $termino) {
                    $fichasPorPrograma = $fichasPorProgramaPorTermino[$termino] ?? collect();

                    $q->where(function ($sub) use ($termino, $fichasPorPrograma) {
                        $sub->where('atenciones.ficha_id', 'like', "%{$termino}%")
                            ->orWhere('atenciones.paciente_id', 'like', "%{$termino}%")
                            ->orWhere('atenciones.id', 'like', "%{$termino}%");

                        if (!is_numeric($termino) && $fichasPorPrograma->isNotEmpty()) {
                            $sub->orWhereIn('atenciones.ficha_id', $fichasPorPrograma);
                        }

                        if (!is_numeric($termino)) {
                            $sub->orWhereExists(function ($exists) use ($termino) {
                                $exists->select(DB::raw(1))
                                    ->from('atencion_motivo')
                                    ->join('motivos', 'motivos.id', '=', 'atencion_motivo.motivo_id')
                                    ->whereColumn('atencion_motivo.atencion_id', 'atenciones.id')
                                    ->where('motivos.motivo', 'like', "%{$termino}%");
                            });
                        }
                    });
                }
            });
    }

    private function buildTopDataPorPrograma($query): Collection
    {
        
        $atencionesPorFicha = (clone $query)
            ->select('ficha_id', DB::raw('count(*) as total'))
            ->groupBy('ficha_id')
            ->get();

        if ($atencionesPorFicha->isEmpty()) {
            return collect();
        }

        $fichasPrograma = DB::connection('senacdti_seguimientopro')
            ->table('sep_ficha')
            ->whereIn('fic_numero', $atencionesPorFicha->pluck('ficha_id'))
            ->pluck('prog_codigo', 'fic_numero');

        return $atencionesPorFicha
            ->filter(function ($item) use ($fichasPrograma) {
                return !empty($fichasPrograma[$item->ficha_id] ?? null);
            })
            ->groupBy(function ($item) use ($fichasPrograma) {
                return $fichasPrograma[$item->ficha_id];
            })
            ->map(function ($grupo, $progCodigo) {
                return (object) [
                    'prog_codigo' => $progCodigo,
                    'total' => $grupo->sum('total'),
                ];
            })
            ->sortByDesc('total')
            ->take(10)
            ->values();
    }
}
