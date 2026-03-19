<div class="border rounded-4 overflow-hidden shadow-sm" style="min-width:600px;">

    <table class="table table-bordered text-center m-0 table-striped">
        <thead>
            <tr>
                <th>ID</th>
                <th>Motivo</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($motivos as $motivo)
                <tr>
                    <td>{{ $motivo->id }}</td>
                    <td>{{ $motivo->motivo }}</td>
                    <td>
                        <button class="btn btn-amarillo btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#editarMotivoModal{{ $motivo->id }}">
                            <i class="bi bi-pencil-square"></i>
                            Editar
                        </button>
                    </td>
                </tr>

                @include('components.modal-motivos.editar-motivo', ['motivo' => $motivo])

            @empty
                <tr>
                    <td colspan="3">
                        <div class="text-center p-3">
                            ❌ No se encontraron resultados
                        </div>
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    {{-- PAGINACIÓN --}}
    <div class="p-3 d-flex justify-content-center">
        {{ $motivos->appends(request()->query())->links() }}
    </div>

</div>