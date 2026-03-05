@extends('layouts.base')

@section('content')
    <div class="container">
        <h2>Atenciones Registradas</h2>

        <a href="" class="btn btn-primary mb-3">Registrar Nueva Atención</a>

        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>ID</th>
                    <th>Paciente</th>
                    <th>Usuario</th>
                    <th>Fecha y Hora</th>
                    <th>Motivo</th>
                    <th>Procedimientos</th>
                    <th>Observaciones</th>
                    <th>Accion</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($atenciones as $atencion)
                    <tr>
                        <td>{{ $atencion->id }}</td>
                        <td>{{ $atencion->paciente->par_nombre }}</td>
                        <td>{{ $atencion->usuario->name }}</td>
                        <td>{{ $atencion->fecha_hora }}</td>
                        <td>{{ $atencion->motivo }}</td>
                        <td>{{ $atencion->procedimientos }}</td>
                        <td>{{ $atencion->observaciones }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Modal de Detalle del Paciente -->
    @foreach ($atenciones as $atencion)
        <!-- fila de tabla ... -->
        <!-- Modal individual para este Paciente -->
        <div class="modal fade" id="modalShowPaciente{{ $atencion->id }}" tabindex="-1"
            aria-labelledby="modalShowLabel{{ $atencion->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #450000;">
                        <h3 class="modal-title text-light">Detalle del Paciente</h3>
                    </div>
                    <div class="card p-3">
                        <div class="card-body">
                            <p><strong>Nombre y apellido:</strong> {{ $atencion->paciente->par_nombre }}
                                {{ $atencion->paciente->par_apellido }}</p>
                            <p><strong>Teléfono:</strong> {{ $atencion->paciente->par_telefono }}</p>
                            <p><strong>Correo:</strong> {{ $atencion->paciente->par_correo }}</p>
                            <p><strong>Fecha de creacion:</strong> {{ $atencion->paciente->created_at }}</p>
                            <p><strong>Fecha ultima edicion:</strong> {{ $atencion->paciente->updated_at }}</p>
                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    @endforeach
@endsection
