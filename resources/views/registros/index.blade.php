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
        <!-- fila de tabla ... -->
        <!-- Modal individual para este Paciente -->
        <div class="modal fade" id="modalShowPaciente{{ $atencion->id }}" tabindex="-1"
            aria-labelledby="modalShowLabel{{ $atencion->id }}" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header" style="background-color: #007832;">
                        <h3 class="modal-title text-light">Detalle del Paciente</h3>
                    </div>
                    <div class="card p-3">
                        <div class="card-body">
                            <p><strong>Nombre y apellido:</strong> {{ $atencion->paciente->par_nombres }}
                                {{ $atencion->paciente->par_apellidos }}</p>
                            <p><strong>Teléfono:</strong> {{ $atencion->paciente->par_telefono ?? 'No registrado' }}</p>
                            <p><strong>Correo:</strong> {{ $atencion->paciente->par_correo ?? 'No registrado' }}</p>
                            <p><strong>Acudiente:</strong>
                                {{ $atencion->paciente->acudiente->par_acu_nombre ?? 'No registrado' }}</p>
                            <p><strong>Tel Acudiente:</strong>
                                {{ $atencion->paciente->acudiente->par_acu_tel ?? 'No registrado' }}</p>
                            <p><strong>Parentesco:</strong>
                                {{ $atencion->paciente->acudiente->par_acu_parentesco ?? 'No registrado' }}</p>
                            <p><strong>Ficha:</strong>
                                {{ $atencion->paciente->ficha->fic_numero ?? 'No registrado' }}</p>
                            <p><strong>Programa:</strong>
                                {{ $atencion->paciente->ficha->fichapro->programa->prog_nombre ?? 'No registrado' }}</p>

                        </div>
                    </div>
                    <button type="button" class="btn btn-secondary mt-3" data-bs-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    @endforeach
@endsection
