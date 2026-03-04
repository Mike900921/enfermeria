@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Atenciones Registradas</h2>

        <a href="{{ route('atenciones.create') }}" class="btn btn-primary mb-3">Registrar Nueva Atención</a>

        <table class="table table-bordered">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Usuario</th>
                    <th>Fecha y Hora</th>
                    <th>Motivo</th>
                    <th>Procedimientos</th>
                    <th>Observaciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($atenciones as $atencion)
                    <tr>
                        <td>{{ $atencion->id }}</td>
                        <td>{{ $atencion->paciente->nombre }}</td>
                        <td>{{ $atencion->usuario->name }}</td>
                        <td>{{ $atencion->fecha_hora }}</td>
                        <td>{{ $atencion->motivo }}</td>
                        <td>{{ $atencion->procedimientos }}</td>
                        <td>{{ $atencion->observaciones }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        {{ $atenciones->links() }}
    </div>
@endsection
