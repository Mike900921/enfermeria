{{-- Este archivo es incluido en registros/index.blade.php para mostrar la tabla de atenciones --}}


{{-- Estilos específicos para esta vista --}}
<style>
    .user-select-auto {
        user-select: text !important;
    }
</style>

<div class="border rounded-4 shadow-sm">
    <div class="table-responsive">
        <table class="table table-striped table-hover align-middle">
            <thead class="table-info">
                <tr>
                    <th><i class="bi bi-hash me-1"></i> ID</th>
                    <th><i class="bi bi-person me-1"></i> Aprendiz</th>
                    <th><i class="bi bi-hospital me-1"></i> EPS</th>
                    <th><i class="bi bi-person-badge me-1"></i> Responsable</th>
                    <th><i class="bi bi-calendar me-1"></i> Fecha y Hora</th>
                    <th><i class="bi bi-chat-dots me-1"></i> Motivo</th>
                    <th><i class="bi bi-gear me-1"></i> Acción</th>
                </tr>
            </thead>
            <tbody class="user-select-auto">
                @forelse ($atenciones as $atencion)
                    <tr>
                        <td>{{ $atencion->paciente->par_identificacion }}</td>
                        <td>{{ $atencion->paciente->par_nombres }}</td>
                        <td>
                            {{ $atencion->paciente?->caracterizacion_apr?->resultados_apr->where('pregunta_id', 7)->first()?->respuesta_texto ?? 'No registrado' }}
                        </td>
                        <td>
                            @if ($atencion->usuario)
                                {{ $atencion->usuario->name }} {{ $atencion->usuario->last_name }}
                                @if ($atencion->usuario->trashed())
                                    <i class="bi bi-person-x text-danger" title="Usuario inactivo"></i>
                                @endif
                            @else
                                N/A
                            @endif
                        </td>
                        <td style="max-width: 150px;">
                            {{ \Carbon\Carbon::parse($atencion->fecha_hora)->format('d/m/Y') }}
                            <span style="margin-left: 10px;">
                                {{ \Carbon\Carbon::parse($atencion->fecha_hora)->format('h:i a') }}
                            </span>
                        </td>
                        <td class="text-truncate" style="max-width: 100px;">
                            {{ $atencion->motivo->isEmpty()
                                ? 'Sin motivo'
                                : ($atencion->motivo->count() === 1
                                    ? $atencion->motivo->first()->motivo
                                    : 'Múltiples') }}
                        </td>
                        <td>
                            <button class="btn btn-success p-1" title="Info usuario" style="font-size: 12px;"
                                data-bs-toggle="modal" data-bs-target="#modalShowPaciente{{ $atencion->id }}">
                                <i class="bi bi-info-circle me-1"></i> Ver Registro
                            </button>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="text-center">No hay registros</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>


{{-- Paginación --}}
@if ($atenciones->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $atenciones->links('pagination::bootstrap-5') }}
    </div>
@endif


<!-- Modal de Detalle del Paciente (boton ver registro) -->
@foreach ($atenciones as $atencion)
    <div class="modal fade" id="modalShowPaciente{{ $atencion->id }}" tabindex="-1">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <!-- ENCABEZADO -->
                <div class="modal-header text-white" style="background:#007832;">
                    <h4 class="modal-title">Informacion Médica</h4>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body user-select-auto">

                    <!-- INFORMACION DEL PACIENTE -->
                    <div class="border p-3 mb-3">
                        <h5 class="text-success user-select-none"><i class="bi bi-person me-1"></i>Datos del Aprendiz
                        </h5>

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
                        <h5 class="text-success user-select-none"><i class="bi bi-heart-pulse me-1"></i>Información
                            Diagnóstico</h5>

                        <p>
                            <strong>Motivo de consulta:</strong><br>
                            {{ $atencion->motivo->pluck('motivo')->join(', ') ?? 'No registrado' }}
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


                    <!-- ACUDIENTE -->
                    <div class="border p-3 mb-3">
                        <h5 class="text-success user-select-none"><i class="bi bi-people me-1"></i>Datos del Acudiente
                        </h5>

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
