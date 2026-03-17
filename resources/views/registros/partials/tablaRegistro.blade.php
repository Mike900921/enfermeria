<style>
    .user-select-auto {
        user-select: text !important;
    }
</style>
<table class="table table-striped table-hover align-middle ">
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
                <td>{{ $atencion->usuario->name }}</td>
                <td style="max-width: 100px;">{{ $atencion->fecha_hora }}</td>
                <td class="text-truncate" style="max-width: 100px;">{{ $atencion->motivo }}</td>
                <td>
                    <button class="btn btn-success p-1" title="Info usuario" style="font-size: 12px;" data-bs-toggle="modal"
                        data-bs-target="#modalShowPaciente{{ $atencion->id }}">
                        Info
                    </button>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No hay registros</td>
            </tr>
        @endforelse
    </tbody>
</table>
@if ($atenciones->hasPages())
    <div class="d-flex justify-content-center mt-3">
        {{ $atenciones->links('pagination::bootstrap-5') }}
    </div>
@endif
