<div style="max-height: 400px; overflow-y: auto;">
<table class="table table-bordered mt-4 text-center">
    <thead>
        <tr>
            <th style="width: 10%; white-space: nowrap; text-align: center;">ID</th>
            <th style="width: 20%; white-space: nowrap; text-align: center;">Motivo</th>
            <th style="width: 20%; white-space: nowrap; text-align: center;">estado</th>
            <th style="width: 20%; white-space: nowrap; text-align: center;">Acciones</th>
        </tr>
    </thead>
    <tbody>
        @foreach($motivos as $motivo)
        <tr>
            <td>{{ $motivo->id }}</td>
            <td>{{ $motivo->motivo }}</td>
            <td>
                @if ($motivo->trashed())

                    Inactivo

                @else
                    Activo
                @endif
            <td>
                <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarMotivoModal{{ $motivo->id }}">Editar</button>
                <!-- Botón para inhabilitar -->
                @if ($motivo->trashed())
                <form action="{{ route('motivos.restore', $motivo->id) }}" method="POST" style="display:inline;">
                    @csrf
                    <button class="btn btn-success btn-sm" onclick="return confirm('¿Restaurar motivo?')">
                        <i class="bi bi-check-lg"></i> Restaurar
                    </button>
                </form>
                @else
                <form action="{{ route('motivos.destroy', $motivo->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Inhabilitar motivo?')">
                        <i class="bi bi-x-lg"></i> Inhabilitar
                    </button>
                </form>
                @endif
            </td>
        </tr>
        <!-- Aquí se incluye el componente del modal para editar, pasando el motivo actual -->
        @include('components.modal-motivos.editar-motivo', ['motivo' => $motivo])
        @endforeach
    </tbody>
</table>
</div>