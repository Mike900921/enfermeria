<?php


namespace App\Http\Controllers\Estadisticas;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class EstadisticaController extends Controller
{
   public function index(Request $request) {

    //validaciones de los inputs de fecha 
        $request->validate([
            'fecha_inicio' => 'nullable|date|required_with:fecha_fin',
            'fecha_fin' => 'nullable|date|after_or_equal:fecha_inicio',
        ], [
            'fecha_inicio.date' => 'La fecha de inicio debe ser una fecha válida.',
            'fecha_fin.date' => 'La fecha de fin debe ser una fecha válida.',
            'fecha_inicio.required_with' => 'La fecha de inicio es requerida cuando se proporciona la fecha fin.',
            'fecha_fin.after_or_equal' => 'La fecha fin debe ser igual o posterior a la fecha de inicio.',
        ]);




    $query = DB::table('atenciones')

            //instructores y estudiantes   
        ->join('senacdti_seguimientopro.sep_ficha', function($join){
           $join->on('atenciones.ficha_id', '=', 'senacdti_seguimientopro.sep_ficha.fic_numero') ;
        })
            //union con programa
        ->join('senacdti_seguimientopro.sep_programa', 
            'senacdti_seguimientopro.sep_programa.prog_codigo', '=', 'senacdti_seguimientopro.sep_ficha.prog_codigo')

        ->join('senacdti_seguimientopro.sep_participante as aprendiz', function($join) {
            $join->on('atenciones.paciente_id', '=', 'aprendiz.par_identificacion'); 
        })

        // Unimos para traer al COORDINADOR
        ->join('senacdti_seguimientopro.sep_participante as coordinador', function($join) {
            $join->on('senacdti_seguimientopro.sep_ficha.par_identificacion_coordinador', '=', 'coordinador.par_identificacion')
                ->where('coordinador.rol_id', '=', 3);
        });


        // Filtros de fecha
        if ($request->filled('fecha_inicio')) {

            $query->whereDate('atenciones.fecha_hora', '>=', $request->fecha_inicio);
        }
        if ($request->filled('fecha_fin')) {
            $query->whereDate('atenciones.fecha_hora', '<=', $request->fecha_fin);
        }

        $ver = $request->get('ver', 'ficha');

        //filtros de seleccion de agrupación
        if ($ver === 'programa') {
            $query->select(
                'senacdti_seguimientopro.sep_programa.prog_nombre as etiqueta',
                'coordinador.par_nombres as nombre_coord',
                'coordinador.par_apellidos as apellido_coord',  
                DB::raw('count(atenciones.id) as total')
            )

            ->groupBy(
                'senacdti_seguimientopro.sep_programa.prog_nombre',
                'coordinador.par_nombres',
                'coordinador.par_apellidos'
            );
        } 
        
        else {
            $query->select(
                'senacdti_seguimientopro.sep_ficha.fic_numero as etiqueta',
                'senacdti_seguimientopro.sep_programa.prog_nombre as programa',
                DB::raw('count(atenciones.id) as total')
            )

            ->groupBy(
                'senacdti_seguimientopro.sep_ficha.fic_numero',
                'senacdti_seguimientopro.sep_programa.prog_nombre',
            );
        }

            //buscador
        if ($request->filled('buscador')) {
            $busqueda = $request->input('buscador');

            $query->where(function($q) use ($busqueda) {
                $q->where('senacdti_seguimientopro.sep_ficha.fic_numero', 'like', "%$busqueda%")
                  ->orWhere('senacdti_seguimientopro.sep_programa.prog_nombre', 'like', "%$busqueda%")
                  ->orWhere(DB::raw("CONCAT(coordinador.par_nombres, ' ', coordinador.par_apellidos)"), 'like', "%$busqueda%");
            });
        }

        $topData = $query->orderBy('total', 'desc')->limit(10)->get();
        $labels = $topData->pluck('etiqueta');
        $values = $topData->pluck('total');

        return view('estadisticas.index', compact('topData', 'labels', 'values', 'ver'));
}
}