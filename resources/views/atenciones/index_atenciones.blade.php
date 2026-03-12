@extends('layouts.base')

@section('titulo', 'Consulta de Pacientes')


@section('content')

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

                    @if ($paciente)
                        <div class="card mb-3 border-success">
                            <div class="card-header bg-success text-white">
                                Datos del Paciente
                            </div>
                            <div class="card-body">
                                <div class="row">
                                    <div class="col-md-3">
                                        <strong>Nombre:</strong><br>
                                        {{ $paciente->par_nombres ?? '' }} {{ $paciente->par_apellidos ?? '' }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Documento:</strong><br>
                                        {{ $paciente->par_identificacion ?? '' }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Programa:</strong><br>
                                        {{ $paciente->ficha->fichapro->programa->prog_nombre ?? 'No registrado' }}
                                    </div>
                                    <div class="col-md-3">
                                        <strong>Ficha:</strong><br>
                                        {{ $paciente->ficha->fic_numero ?? 'No registrado' }}
                                    </div>

                                    <div class="col-12 mt-3">
                                        <button class="btn btn-success mt-4" title="Registrar nueva atención"
                                            data-bs-toggle="modal"
                                            data-bs-target="#modalCreateAtencion{{ $paciente->par_identificacion }}">
                                            Registrar Nueva Atención
                                        </button>
                                    </div>
                                </div>
                            </div>

                        </div>

                        {{-- HISTORIAL DE ATENCIONESese --}}
                        <div class="card border-primary">
                            <div class="card-header bg-primary text-white">
                                Historial de Atenciones
                            </div>
                            <div class="card-body">
                                @if ($paciente->atenciones->count() > 0)
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
                                            @foreach ($paciente->atenciones as $atencion)
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

                    <!-- Modal para registrar nueva atención - OJO tiene que ir dentro del if paciente--->
                    <div class="modal fade" id="modalCreateAtencion{{ $paciente->par_identificacion }}"tabindex="-1"
                        aria-hidden="true">
                        <div class="modal-dialog modal-lg">
                            <div class="modal-content">

                                <div class="modal-header" style="background-color: #007832;">
                                    <h5 class="modal-title text-light">Registrar Nueva Atención</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>

                                <form action="{{ route('atenciones.store') }}" method="POST">
                                    @csrf

                                    <div class="modal-body">

                                        <!-- DATOS DEL PACIENTE (NO EDITABLES) -->
                                        <div class="row mb-3">

                                            <div class="col-md-3">
                                                <label class="form-label"><strong>Nombre</strong></label>
                                                <input type="text" class="form-control"
                                                    value="{{ $paciente->par_nombres ?? '' }} {{ $paciente->par_apellidos ?? '' }}"
                                                    readonly>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label"><strong>Documento</strong></label>
                                                <input name="paciente_id" type="text" class="form-control"
                                                    value="{{ $paciente->par_identificacion ?? '' }}" readonly>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label"><strong>Programa</strong></label>
                                                <input type="text" class="form-control"
                                                    value="{{ $paciente->ficha->fichapro->programa->prog_nombre ?? 'No registrado' }}"
                                                    readonly>
                                            </div>

                                            <div class="col-md-3">
                                                <label class="form-label"><strong>Ficha</strong></label>
                                                <input name="ficha_id" type="text" class="form-control"
                                                    value="{{ $paciente->ficha->fic_numero ?? 'No registrado' }}" readonly>
                                            </div>

                                        </div>


                                        <hr>

                                        <!-- CAMPOS EDITABLES -->

                                        <div class="mb-3">
                                            <label class="form-label">Fecha y Hora</label>
                                            <input type="datetime-local" name="fecha_hora"
                                                value="{{ now()->format('Y-m-d\TH:i') }}" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Motivo</label>
                                            <textarea name="motivo" class="form-control" required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Procedimientos</label>
                                            <textarea name="procedimientos" class="form-control"></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Observaciones</label>
                                            <textarea name="observaciones" class="form-control"></textarea>
                                        </div>

                                    </div>

                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                            Cancelar
                                        </button>

                                        <button type="submit" class="btn btn-primary">
                                            Registrar Atención
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
        </div>
    </div>

@endsection
