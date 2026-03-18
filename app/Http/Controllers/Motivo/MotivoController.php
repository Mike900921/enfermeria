<?php

namespace App\Http\Controllers\Motivo;
use App\Http\Controllers\Controller;
use App\Models\Motivo\Motivo;
use Illuminate\Http\Request;


class MotivoController extends Controller
{    
    public function index()
    {
        $motivos = Motivo::all();
        return view('motivos.index', compact('motivos'));
    }

    public function create()
    {
        return view('motivos.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
        ]);

        Motivo::create([
            'nombre' => $request->input('nombre'),
        ]);

        return redirect()->route('motivos.index')->with('success', 'Motivo creado exitosamente.');
    }

}