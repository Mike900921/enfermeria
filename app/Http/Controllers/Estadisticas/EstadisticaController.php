<?php


namespace App\Http\Controllers\Estadisticas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Atencion\Atencion;
use App\Models\Ficha\Ficha;
use App\Models\Ficha\FichaPro;
use App\Models\Programa\Programa;

class EstadisticaController extends Controller
{
    public function index(Request $request)
    {

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


        //-------------------------------Lógica automática,Si hay búsqueda y parece un ID de paciente------------------------------------------
        $busqueda = $request->input('buscador');
        $ver = $request->get('ver', 'ficha');

            if ($request->filled('buscador')) {

                if (is_numeric($busqueda) && strlen($busqueda) >= 8) {
                    $ver = 'pacientes';
                } elseif (is_numeric($busqueda) && strlen($busqueda) < 8) {
                    $ver = 'ficha';
                } else {
                    $ver = 'programa';
                }
            }


        //--------------------consulta base para las estadísticas, con joins para traer la información relacionada de fichas, programas, aprendices y coordinadores--------------------------------

        // Consulta Base con Filtros (Optimizada)
        $query = Atencion::query()
            ->when($request->filled('fecha_inicio'), function ($q) use ($request) {
                $q->whereDate('atenciones.fecha_hora', '>=', $request->fecha_inicio);
            })
            ->when($request->filled('fecha_fin'), function ($q) use ($request) {
                $q->whereDate('atenciones.fecha_hora', '<=', $request->fecha_fin);
            })
            ->when($request->filled('buscador'), function ($q) use ($busqueda) {
                $q->where(function ($sub) use ($busqueda) {
                    // 1. Búsqueda básica por IDs (Siempre rápida)
                    $sub->where('atenciones.ficha_id', 'like', "%{$busqueda}%")
                        ->orWhere('atenciones.paciente_id', 'like', "%{$busqueda}%");

                    // 2. Búsqueda por nombre de programa (Solo si no es puramente numérico)
                    if (!is_numeric($busqueda)) {
                        $sub->orWhereExists(function ($exists) use ($busqueda) {
                            $exists->select(DB::raw(1))
                                ->from('senacdti_seguimientopro.sep_ficha as f_ext')
                                ->join('senacdti_seguimientopro.sep_programa as p_ext', 'f_ext.prog_codigo', '=', 'p_ext.prog_codigo')
                                ->whereColumn('f_ext.fic_numero', 'atenciones.ficha_id')
                                ->where('p_ext.prog_nombre', 'like', "%{$busqueda}%");
                        });
                    }
                });
            });

        // Agrupación por Vista
        if ($ver === 'programa') {
            // Para agrupar por programa, el JOIN es obligatorio
            $topData = $query->join('senacdti_seguimientopro.sep_ficha as f', 'atenciones.ficha_id', '=', 'f.fic_numero')
                ->select('f.prog_codigo', 'atenciones.ficha_id', DB::raw('count(atenciones.id) as total'))
                ->groupBy('f.prog_codigo', 'atenciones.ficha_id');
        } elseif ($ver === 'pacientes') {
            $topData = $query->select('paciente_id', 'ficha_id', DB::raw('count(*) as total'))
                ->groupBy('paciente_id', 'ficha_id');
        } else {
            $topData = $query->select('ficha_id', DB::raw('count(*) as total'))
                ->groupBy('ficha_id');
        }

        // Ejecución (Traemos los 10 mejores)
        $topData = $topData->orderBy('total', 'desc')->limit(10)->get();

        // Carga de Relaciones (Aquí es donde recuperamos los nombres para los 10 resultados)
        $topData->load(['paciente', 'ficha.fichapro.programa', 'ficha.fichapro.coordinador']);


        // Mapeo de datos para la Vista (Llenamos las variables que usa tu Blade)
        $topData->transform(function ($item) use ($ver) {
            if ($ver === 'programa') {
                $item->etiqueta = $item->ficha->fichapro->programa->prog_nombre ?? 'N/A';
                $item->nombre_coord = $item->ficha->fichapro->coordinador->par_nombres ?? 'Sin';
                $item->apellido_coord = $item->ficha->fichapro->coordinador->par_apellidos ?? 'Coordinador';
            } elseif ($ver === 'pacientes') {
                $item->etiqueta = $item->paciente
                    ? ($item->paciente->par_nombres . ' ' . $item->paciente->par_apellidos)
                    : "ID: {$item->paciente_id}";
                $item->numeroDocumento = $item->paciente_id;
                $item->fichaPaciente = $item->ficha_id ?? 'N/A';
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
}
