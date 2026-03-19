<?php

namespace App\Http\Controllers\Motivo;

use App\Http\Controllers\Controller;
use App\Models\Motivo\Motivo;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Gate;


class MotivoController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->query('filter', 'todo');

        $query = Motivo::withTrashed();

        if ($filter === 'activos') {
            $query->whereNull('deleted_at');
        } elseif ($filter === 'inactivos') {
            $query->onlyTrashed();
        }

        $motivos = $query->paginate(10);

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

        return redirect()->route('motivos.index')->with('success', 'Motivo creado exitosamente.');
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
