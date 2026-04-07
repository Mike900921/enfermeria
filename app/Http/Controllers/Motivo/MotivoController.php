<?php

namespace App\Http\Controllers\Motivo;

use App\Http\Controllers\Controller;
use App\Models\Motivo\Motivo;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;
use Illuminate\Validation\Rule;


class MotivoController extends Controller
{
    public function index(Request $request)
    {
        $query = Motivo::withTrashed();

        if ($request->q) {
            $query->where('motivo', 'like', "%{$request->q}%");
        }

        $motivos = $query->paginate(10)->withQueryString();

        if ($request->ajax()) {
            return view('motivos.partials.tablaMotivos', compact('motivos'))->render();
        }

        return view('motivos.motivos', compact('motivos'));
    }

    public function buscar(Request $request)
    {
        $texto = $request->get('q');

        $motivos = Motivo::withTrashed()
            ->when($texto, function ($query, $texto) {
                $query->where('motivo', 'like', "%$texto%")
                    ->orWhere('id', 'like', "%$texto%");
            })
            ->paginate(10);

        return view('motivos.partials.tablaMotivos', compact('motivos'))->render();
    }
    public function create(Request $request) {}

    //creación de motivo
    public function store(Request $request)
    {
        $request->validate([

            'nombre' => 'required|string|max:255',
        ]);

        Motivo::create([
            'motivo' => $request->input('nombre'),
        ]);

        return redirect()->back()->with('success', 'Motivo creado exitosamente.');
    }

    public function storeFromAtencion(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'paciente_id' => [
                'required',
                Rule::exists('senacdti_seguimientopro.sep_participante', 'par_identificacion'),
            ],
        ]);
        Motivo::create([
            'motivo' => $request->input('nombre'),
        ]);

        return redirect()
            ->route('atenciones.index_atenciones', ['cedula' => $request->paciente_id])
            ->with('success', 'Motivo creado exitosamente.');
    }
    //actualización de motivo
    public function update(Request $request, $id)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        $motivo = Motivo::findOrFail($id);
        $motivo->update([
            'motivo' => $request->input('nombre'),
        ]);

        return redirect()->route('motivos.index')->with('success', 'Motivo actualizado exitosamente.');
    }

    // 1. Inhabilitar (Borrado suave)
    public function destroy($id)
    {
        $motivo = Motivo::findOrFail($id);
        $motivo->delete(); // Esto NO lo borra de la DB, solo pone la fecha en deleted_at

        return redirect()->back()->with('success', 'Motivo inhabilitado correctamente.');
    }

    // 2. Restaurar (Volver a habilitar)
    public function restore($id)
    {
        // Usamos withTrashed() porque si está inhabilitado, findOrFail no lo encontraría solo
        $motivo = Motivo::withTrashed()->findOrFail($id);
        $motivo->restore(); // Limpia la fecha de deleted_at

        return redirect()->back()->with('success', 'Motivo habilitado de nuevo.');
    }
}
