@extends('layouts.base')

@section('content')
    <div class="container">
        <h2>Atenciones Registradas</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <div class="d-flex mb-2">
            <input id="fecha_inicio" type="date" class="form-control me-2" placeholder="Fecha inicio">
            <input id="fecha_fin" type="date" class="form-control me-2" placeholder="Fecha fin">
            <input id="input-busqueda" class="form-control me-2" placeholder="Buscar Paciente..." />
            <button id="btn-buscar" class="btn btn-outline-success" type="submit">Buscar</button>
        </div>

        <a id="btn-excel" href="{{ route('atenciones.export') }}" class="btn btn-success ms-2">
            <i class="bi bi-file-earmark-excel"></i> Descargar Excel
        </a>

        <div id="tabla-pacientes" class="mt-5">
            @include('registros.partials.tablaRegistro')
        </div>
    </div>


    <script>
        const URL_REGISTROS = "{{ route('registros.index') }}";
        const URL_EXCEL = "{{ route('atenciones.export') }}";
    </script>

    <!-- Incluir el script del buscador de public/js/BuscadorRegistro.js -->
    <script src="{{ asset('js/BuscadorRegistro.js') }}"></script>


    <!-- Modal de Detalle del Paciente -->
    @foreach ($atenciones as $atencion)
        <div class="modal fade" id="modalShowPaciente{{ $atencion->id }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <!-- ENCABEZADO -->
                    <div class="modal-header text-white" style="background:#007832;">
                        <h4 class="modal-title">Informacion Médica</h4>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- INFORMACION DEL PACIENTE -->
                        <div class="border p-3 mb-3">
                            <h5 class="text-success">Datos del Paciente</h5>

                            <div class="row">
                                <div class="col-md-6">
                                    <strong>Nombre:</strong>
                                    {{ $atencion->paciente->par_nombres }} {{ $atencion->paciente->par_apellidos }}
                                </div>

                                <div class="col-md-3">
                                    <strong>Teléfono:</strong>
                                    {{ $atencion->paciente->par_telefono ?? 'No registrado' }}
                                </div>

                                <div class="col-md-3">
                                    <strong>Ficha:</strong>
                                    {{ $atencion->paciente->ficha->fic_numero ?? 'No registrado' }}
                                </div>
                            </div>

                            <div class="row mt-2">
                                <div class="col-md-6">
                                    <strong>Programa:</strong>
                                    {{ $atencion->paciente->ficha->fichapro->programa->prog_nombre ?? 'No registrado' }}
                                </div>

                                <div class="col-md-6">
                                    <strong>Correo:</strong>
                                    {{ $atencion->paciente->par_correo ?? 'No registrado' }}
                                </div>
                            </div>
                        </div>


                        <!-- INFORMACION CLINICA -->
                        <div class="border p-3 mb-3 text-break">
                            <h5 class="text-success">Información Clínica</h5>

                            <p>
                                <strong>Motivo de consulta:</strong><br>
                                {{ $atencion->motivo ?? 'No registrado' }}
                            </p>

                            <p>
                                <strong >Procedimientos:</strong><br>
                                {{ $atencion->procedimientos ?? 'No registrado' }}
                            </p>

                            <p>
                                <strong >Observaciones:</strong><br>
                                {{ $atencion->observaciones ?? 'No registrado' }}
                            </p>
                        </div>


                        <!-- ACUDIENTE -->
                        <div class="border p-3 mb-3">
                            <h5 class="text-success">Datos del Acudiente</h5>

                            <div class="row">
                                <div class="col-md-5">
                                    <strong>Nombre:</strong>
                                    <p>{{ $atencion->paciente->acudiente->par_acu_nombre ?? 'No registrado' }}</p>
                                </div>

                                <div class="col-md-3">
                                    <strong>Teléfono:</strong>
                                    <p>{{ $atencion->paciente->acudiente->par_acu_tel ?? 'No registrado' }}</p>
                                </div>

                                <div class="col-md-3">
                                    <strong>Parentesco:</strong>
                                    <p>{{ $atencion->paciente->acudiente->par_acu_parentesco ?? 'No registrado' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- BOTONES -->
                    <div class="modal-footer">
                        <a href="{{ route('atencionesPdf', $atencion->id) }}" class="btn btn-success" target="_blank">
                            Imprimir Orden
                        </a>

                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            Cerrar
                        </button>
                    </div>
                </div>
            </div>
        </div>
    @endforeach
@endsection
