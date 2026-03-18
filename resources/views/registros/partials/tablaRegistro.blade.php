<style>
    .user-select-auto {
        user-select: text !important;
    }
</style>
<div class="border rounded-4 overflow-hidden shadow-sm">
    <table class="table table-striped table-hover align-middle text-center mb-0">
        <thead class="table-light">
            <tr>
                <th>ID</th>
                <th>Paciente</th>
                <th>Usuario</th>
                <th>Fecha y Hora</th>
                <th>Motivo</th>
                <th>Accion</th>
            </tr>
        </thead>
        <tbody class="user-select-auto">
            @forelse ($atenciones as $atencion) 
                <tr>
                    <td>{{ $atencion->paciente->par_identificacion }}</td>
                    <td>{{ $atencion->paciente->par_nombres }}</td>
                    <td>{{ $atencion->usuario->name ?? 'N/A' }}</td>
                    <td style="max-width: 150px;"> {{-- Aumenté un poco el max-width para que no se amontone --}}
                        {{ \Carbon\Carbon::parse($atencion->fecha_hora)->format('d/m/Y') }}
                        <span style="margin-left: 10px;">
                            {{ \Carbon\Carbon::parse($atencion->fecha_hora)->format('h:i a') }}
                        </span>
                    </td>
                    <td class="text-truncate" style="max-width: 100px;">{{ $atencion->motivo }}</td>
                    <td>
                        <button class="btn btn-success p-1 " title="Info usuario" style="font-size: 15px;" data-bs-toggle="modal"
                            data-bs-target="#modalShowPaciente{{ $atencion->id }}">
                            <i class="bi bi-info-circle"></i> Ver registro
                        </button>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">No hay registros</td> {{-- Cambié el colspan a 6 porque tienes 6 columnas --}}
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@if ($atenciones->hasPages())
<div class="d-flex justify-content-center mt-3">
    {{ $atenciones->links('pagination::bootstrap-5') }}
</div>
@endif
