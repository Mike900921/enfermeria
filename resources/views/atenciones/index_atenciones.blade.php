@extends('layouts.base')

@section('titulo', 'Consulta de Pacientes')

@section('contenido')
<div class="container mt-4">
    
    <div class="card shadow-sm">
        <div class="card-header header-institucional text-center">
            <h5 class="mb-0">Consulta de Paciente</h5>
        </div>

        <div class="card-body">

            {{-- FORMULARIO --}}
            <form action="{{ route('consulta.buscar') }}" method="POST">
                @csrf

                <div class="row">
                    <div class="col-md-8">
                        <label class="form-label">Número de Documento</label>
                        <input type="text" name="cedula" class="form-control" required>
                    </div>

                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-sena w-100">
                            Consultar
                        </button>
                    </div>
                </div>
            </form>

            {{-- RESULTADOS --}}
            @isset($paciente)
                <hr>

                @if($paciente)

                    {{-- DATOS DEL PACIENTE --}}
                    <div class="card mb-3 border-success">
                        <div class="card-header bg-success text-white">
                            Datos del Paciente
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4">
                                    <strong>Nombre:</strong><br>
                                    {{ $paciente->nombre }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Documento:</strong><br>
                                    {{ $paciente->numero_documento }}
                                </div>
                                <div class="col-md-4">
                                    <strong>Programa:</strong><br>
                                    {{ $paciente->programa ?? 'No registrado' }}
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- HISTORIAL DE ATENCIONES --}}
                    <div class="card border-primary">
                        <div class="card-header bg-primary text-white">
                            Historial de Atenciones
                        </div>
                        <div class="card-body">

                            @if($paciente->atenciones->count() > 0)

                                <table class="table table-bordered table-striped">
                                    <thead class="table-dark">
                                        <tr>
                                            <th>Fecha</th>
                                            <th>Motivo</th>
                                            <th>Procedimientos</th>
                                            <th>Observaciones</th>
                                            <th>Enfermero</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($paciente->atenciones as $atencion)
                                            <tr>
                                                <td>{{ $atencion->fecha_hora }}</td>
                                                <td>{{ $atencion->motivo }}</td>
                                                <td>{{ $atencion->procedimientos }}</td>
                                                <td>{{ $atencion->observaciones }}</td>
                                                <td>{{ $atencion->usuario->name ?? 'No disponible' }}</td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>

                            @else
                                <div class="alert alert-info">
                                    Este paciente no tiene atenciones registradas.
                                </div>
                            @endif

                        </div>
                    </div>

                @else
                    <div class="alert alert-danger mt-3">
                        No se encontró ningún paciente con ese documento.
                    </div>
                @endif

            @endisset

        </div>
    </div>
</div>
@endsection