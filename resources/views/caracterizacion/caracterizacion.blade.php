@extends('layouts.base')

@section('titulo', 'Consulta de Pacientes')

@section('content')

<div class="container mt-4">
    <div class="card shadow">
        <div class="card-header">
            <h4>Encuesta de Caracterizacion</h4>
        </div>

        <div class="card-body text-center">
            <p>Haz clic en el botón para ingresar a SETALPRO y diligenciar la encuesta de caracterización.</p>

            <a href="https://setalpro.senacdti.com" class=" btn btn-verde" target="_blank">
                <i class="bi bi-search"></i> Ir a setalpro
            </a>
        </div>
    </div>
    <div class="card-body text-center " style="margin-top: 80px;">
        
        {!! QrCode::size(200)->generate('https://setalpro.senacdti.com/login') !!}

    </div>
</div>

@endsection