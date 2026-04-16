<div class="border rounded-4 overflow-hidden shadow-sm" style="min-width:600px;">

    <table class="table table-bordered table-striped table-hover shadow-sm text-center align-middle m-0">
        <thead class="table-info">
            <tr>
                <th>ID</th>
                <th>Motivo</th>
                @can('gestionar-usuarios')
                    <th>Acciones</th>
                @endcan
            </tr>
        </thead>

        <tbody>
            @forelse($motivos as $motivo)
                <tr>
                    <td>{{ $motivo->id }}</td>
                    <td>{{ $motivo->motivo }}</td>
                    @can('gestionar-usuarios')
                        <td>
                            <button class="btn btn-amarillo btn-sm btn-editar" data-id="{{ $motivo->id }}"
                                data-motivo="{{ $motivo->motivo }}" data-bs-toggle="modal" data-bs-target="#editarMotivoModal">
                                <i class="bi bi-pencil-square"></i>
                                Editar
                            </button>
                        </td>
                    @endcan
                </tr>
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

    {{-- MODAL EDITAR --}}
    <div class="modal fade" id="editarMotivoModal" tabindex="-1">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Editar motivo</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <form id="formEditarMotivo" method="POST">
                    @csrf
                    @method('PUT')

                    <div class="modal-body">
                        <input type="hidden" id="edit_id">

                        <div class="mb-3">
                            <label class="form-label fw-bold">Actualizar motivo</label>
                            <input type="text" id="edit_motivo" name="nombre" class="form-control">
                        </div>
                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-verde">Actualizar</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('click', function(e) {
            if (e.target.closest('.btn-editar')) {

                let btn = e.target.closest('.btn-editar');

                let id = btn.dataset.id;
                let motivo = btn.dataset.motivo;

                // llenar inputs
                document.getElementById('edit_id').value = id;
                document.getElementById('edit_motivo').value = motivo;

                // cambiar action del form dinámicamente
                let form = document.getElementById('formEditarMotivo');
                form.action = `/motivos/${id}`;
            }
        });
    </script>


    @if ($motivos->hasPages())
        {{-- PAGINACIÓN --}}
        <div class="p-3 d-flex justify-content-center">
            {{ $motivos->appends(request()->query())->links() }}
        </div>
    @endif
</div>
