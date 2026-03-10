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
        @forelse ($atenciones as $atencion)
            <tr>
                <td>{{ $atencion->paciente->par_identificacion }}</td>
                <td>{{ $atencion->paciente->par_nombres }}</td>
                <td>{{ $atencion->usuario->name }}</td>
                <td>{{ $atencion->fecha_hora }}</td>
                <td>{{ $atencion->motivo }}</td>
                <td>{{ $atencion->procedimientos }}</td>
                <td>{{ $atencion->observaciones }}</td>
                <td>
                    <button class="btn btn-success p-1" title="Info usuario" style="font-size: 12px;" data-bs-toggle="modal"
                        data-bs-target="#modalShowPaciente{{ $atencion->id }}">
                        <i class="bi bi-info-circle"></i>
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
