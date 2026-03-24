@extends('layouts.base')

@section('titulo', 'Consulta de Pacientes')


@section('content')
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <style>
        .user-select-auto {
            user-select: text !important;
        }
    </style>

    <div class="container mt-4 user-select-none">
        <div class="card shadow-sm">
            <div class="card-header header-institucional text-center">
                <h5 class="mb-0">Consulta de Paciente</h5>

            </div>
            @if (session('success'))
                <div
                    style="
                    position: fixed;
                    top: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    z-index: 9999;
                    width: auto;
                    max-width: 90%;
                    ">
                    <div class="alert alert-success alert-dismissible fade show shadow-lg border-0" role="alert"
                        style="border-radius: 20px; padding-right: 50px;">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            @if ($errors->any())
                <div
                    style="
                    position: fixed;
                    top: 20px;
                    left: 50%;
                    transform: translateX(-50%);
                    z-index: 9999;
                    width: auto;
                    max-width: 90%;">
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show shadow-lg border-0" role="alert"
                            style="border-radius: 20px; padding-right: 50px;">
                            <i class="fas fa-check-circle me-2"></i> {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                </div>
            @endforeach
            @endif


            <div class="card-body">

                {{-- FORMULARIO --}}
                <form action="{{ route('consulta.buscar') }}" method="POST">
                    @csrf

                    <div class="row">
                        <div class="col-md-8">
                            <label class="form-label">Número de Documento</label>
                            <input type="text" name="cedula" class="form-control"
                                value="{{ $paciente->par_identificacion ?? '' }}" required>
                        </div>

                        <div class="col-md-4 d-flex align-items-end">
                            <button type="submit" class="btn btn-verde w-100">
                                <i class="bi bi-search"></i> Consultar
                            </button>
                        </div>
                    </div>
                </form>

                {{-- RESULTADOS --}}
                @isset($paciente)
                    <hr>

                    @if ($paciente)
                        <div class="card mb-3 border-azul-claro">
                            <div class="card-header bg-azul-claro text-dark">
                                Datos del Paciente
                            </div>
                            <div class="card-body user-select-auto">
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

                                    <div class="d-flex gap-3 mt-3">
                                        <button class="btn btn-verde" title="Registrar nueva atención" data-bs-toggle="modal"
                                            data-bs-target="#modalCreateAtencion{{ $paciente->par_identificacion }}">
                                            <i class="bi bi-plus-circle"></i> Registrar Nueva Atención
                                        </button>

                                        <button class="btn btn-verde" data-bs-toggle="modal"
                                            data-bs-target="#modalShowPaciente{{ $paciente->par_identificacion }}">
                                            <i class="bi bi-info-circle"></i> Ver información del paciente
                                        </button>
                                    </div>

                                </div>
                            </div>
                        </div>

                        {{-- HISTORIAL DE ATENCIONESese --}}
                        <div class="card border-azul-claro">
                            <div class="card-header bg-azul-claro text-dark">
                                Historial de Atenciones
                            </div>
                            <div class="card-body">
                                <div class="border rounded-4 overflow-hidden shadow-sm">
                                    @if ($paciente->atenciones->count() > 0)
                                        <table
                                            class="mb-0 table table-bordered table-striped table-hover shadow-sm text-center align-middle">
                                            <thead class="table-success">
                                                <tr>
                                                    <th><i class="bi bi-calendar"></i> Fecha</th>
                                                    <th><i class="bi bi-chat-dots"></i> Motivo</th>
                                                    <th><i class="bi bi-person-badge"></i> Enfermero</th>
                                                    <th><i class="bi bi-gear"></i> Acción</th>
                                                </tr>
                                            </thead>
                                            <tbody class="user-select-auto">
                                                @foreach ($paciente->atenciones as $atencion)
                                                    <tr>
                                                        <td>{{ $atencion->fecha_hora }}</td>
                                                        <td class="text-truncate" style="max-width: 100px;">

                                                            {{ $atencion->motivo ?? 'No registrado' }}
                                                        </td>


                                                        <td>{{ $atencion->usuario->name ?? 'No disponible' }}</td>
                                                        <td>
                                                            <button class="btn btn-verde p-1" title="Info usuario"
                                                                style="font-size: 12px;" data-bs-toggle="modal"
                                                                data-bs-target="#modalInfoPaciente{{ $atencion->id }}">
                                                                <i class="bi bi-info-circle"></i> Ver Registro
                                                            </button>
                                                        </td>
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
                        </div>
                    @else
                        <div class="alert alert-danger mt-3">
                            No se encontró ningún paciente con ese documento.
                        </div>
                    @endif

                    <!-- Modal para registrar nueva atención - OJO tiene que ir dentro del isset paciente--->
                    <div class="modal fade" id="modalCreateAtencion{{ $paciente->par_identificacion }}" tabindex="-1"
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
                                            <input type="hidden" name="fecha_hora"
                                                value="{{ now()->format('Y-m-d\TH:i') }}" class="form-control" required>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Motivo</label>

                                            <div class="input-group">
                                                <select name="motivo_id[]" multiple id="motivo_id" class="form-control" required>
                                                    <option value="">Seleccione un motivo</option>
                                                    @foreach ($motivos as $motivo)
                                                        <option value="{{ $motivo->id }}">
                                                            {{ $motivo->motivo }}
                                                        </option>
                                                    @endforeach
                                                </select>

                                                <!-- Botón para agregar -->
                                                <button type="button" class="btn btn-primary" data-bs-toggle="modal"
                                                    data-bs-target="#modalMotivo">
                                                    +
                                                </button>
                                            </div>
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

                    <!-- Modal para agregar nuevo motivo -->
                    <div class="modal fade" id="modalMotivo" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header" style="background-color: #007832;">
                                    <h5 class="modal-title text-light">Agregar Nuevo Motivo</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                </div>
                                <form action="{{ route('motivos.store') }}" method="POST">
                                    @csrf
                                    <div class="modal-body">
                                        <div class="mb-3">
                                            <label class="form-label">Motivo de Consulta</label>
                                            <input type="text" name="nombre" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button"
                                            class="btn btn-secondary"data-bs-target="#modalCreateAtencion{{ $paciente->par_identificacion }}"
                                            data-bs-toggle="modal">
                                            Cancelar
                                        </button>
                                        <button type="submit" class="btn btn-primary">
                                            Agregar Motivo
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

    {{-- Modal de Detalle del Paciente --}}
    @isset($paciente)
        <div class="modal fade user-select-none" id="modalShowPaciente{{ $paciente->par_identificacion }}" tabindex="-1">
            <div class="modal-dialog modal-lg">
                <div class="modal-content shadow">

                    <!-- HEADER -->
                    <div class="modal-header text-white" style="background-color:#007832;">
                        <h5 class="modal-title">
                            <i class="bi bi-person-badge"></i> Información del Paciente
                        </h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body">

                        <!-- DATOS DEL PACIENTE -->
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-header bg-verde text-white">
                                <i class="bi bi-person"></i> Datos del Paciente
                            </div>

                            <div class="card-body user-select-auto">
                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <strong>Nombre:</strong><br>
                                        {{ $paciente->par_nombres }} {{ $paciente->par_apellidos }}
                                    </div>

                                    <div class="col-md-3">
                                        <strong>Teléfono:</strong><br>
                                        {{ $paciente->par_telefono ?? 'No registrado' }}
                                    </div>

                                    <div class="col-md-3">
                                        <strong>Correo:</strong><br>
                                        {{ $paciente->par_correo ?? 'No registrado' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- ACUDIENTE -->
                        <div class="card border-0 shadow-sm mb-3">
                            <div class="card-header bg-azul text-white">
                                <i class="bi bi-people"></i> Información del Acudiente
                            </div>

                            <div class="card-body user-select-auto">
                                <div class="row">
                                    <div class="col-md-4">
                                        <strong>Nombre:</strong><br>
                                        {{ $paciente->acudiente->par_acu_nombre ?? 'No registrado' }}
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Teléfono:</strong><br>
                                        {{ $paciente->acudiente->par_acu_tel ?? 'No registrado' }}
                                    </div>

                                    <div class="col-md-4">
                                        <strong>Parentesco:</strong><br>
                                        {{ $paciente->acudiente->par_acu_parentesco ?? 'No registrado' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- INFORMACION ACADEMICA -->
                        <div class="card border-0 shadow-sm">
                            <div class="card-header bg-verde text-white">
                                <i class="bi bi-folder"></i> Información de Ficha
                            </div>

                            <div class="card-body user-select-auto">
                                <div class="row">
                                    <div class="col-md-6">
                                        <strong>Número de ficha:</strong><br>
                                        {{ $paciente->ficha->fic_numero ?? 'No registrado' }}
                                    </div>

                                    <div class="col-md-6">
                                        <strong>Programa:</strong><br>
                                        {{ $paciente->ficha->fichapro->programa->prog_nombre ?? 'No registrado' }}
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- FOOTER -->
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-bs-dismiss="modal">
                            <i class="bi bi-x-circle"></i> Cerrar
                        </button>
                    </div>

                </div>
            </div>
        </div>
    @endisset

    {{-- Modal para más info del Paciente (boton ver registro) --}}
    @isset($paciente)
        @foreach ($paciente->atenciones as $atencion)
            <div class="modal fade user-select-none" id="modalInfoPaciente{{ $atencion->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg"> <!-- modal-lg para más ancho -->
                    <div class="modal-content">

                        <div class="modal-header" style="background-color:#007832;">
                            <h5 class="modal-title text-light">
                                <i class="bi bi-info-circle me-1"></i>Información del Paciente
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>

                        <div class="modal-body">
                            <!-- INFORMACION DEL PACIENTE -->
                            <div class="border p-3 mb-3 user-select-auto">
                                <h5 class="text-success"><i class="bi bi-person me-1"></i>Datos del Paciente</h5>

                                <div class="row mb-2">
                                    <div class="col-md-6">
                                        <strong>Nombre:</strong>
                                        {{ $atencion->paciente->par_nombres }} {{ $atencion->paciente->par_apellidos }}
                                    </div>

                                    <div class="col-md-3">
                                        <strong>N.cedula:</strong>
                                        {{ $atencion->paciente->par_identificacion }}
                                    </div>

                                    <div class="col-md-6">
                                        <strong>Teléfono:</strong>
                                        {{ $atencion->paciente->par_telefono ?? 'No registrado' }}
                                    </div>

                                    <div class="col-md-6">
                                        <strong>Ficha:</strong>
                                        {{ $atencion->paciente->ficha->fic_numero ?? 'No registrado' }}
                                    </div>
                                </div>

                                <!-- INFORMACION CLINICA -->
                                <div class="border p-3 mb-3">
                                    <h5 class="text-success"><i class="bi bi-heart-pulse me-1"></i>Información Atención</h5>

                                    <p>
                                        <strong>Motivo de consulta:</strong><br>
                                        {{ $atencion->motivo ?? 'No registrado' }}
                                    </p>

                                    <p>
                                        <strong>Procedimientos:</strong><br>
                                        {{ $atencion->procedimientos ?? 'No registrado' }}
                                    </p>

                                    <p>
                                        <strong>Observaciones:</strong><br>
                                        {{ $atencion->observaciones ?? 'No registrado' }}
                                    </p>
                                </div>

                            </div>

                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">
                                    <i class="bi bi-x-circle me-1"></i>Cerrar
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @endisset
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

     <script>
        // Inicialización
        new TomSelect('#motivo_id', {
            plugins: ['remove_button'],
            sortField: {
                field: 'text',
                direction: 'asc'
            },
            create: false,
            // Esto mejora la apariencia en móviles
            maxOptions: 50,
            render: {
                no_results: function(data, escape) {
                    return '<div class="no-results">No se encontró "' + escape(data.input) + '"</div>';
                }
            }
        });
    </script>

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert-success');
            if (alert) alert.style.display = 'none';
        }, 5000); // 5 segundos
    </script>

@endsection
