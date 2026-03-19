<div class="modal fade" id="editarMotivoModal{{ $motivo->id }}" tabindex="-1" aria-labelledby="editarMotivoLabel{{ $motivo->id }}" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="editarMotivoLabel{{ $motivo->id }}">Editar motivo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>

            <form action="{{ route('motivos.update', $motivo->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-body">
                    <div class="mb-3">
                        <label for="motivo" class="form-label fw-bold">Actualizar motivo</label>
                        <input type="text" value="{{ $motivo->motivo }}" name="nombre" class="form-control" id="motivo" placeholder="Ingrese el motivo">
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">cancelar</button>
                    <button type="submit" class="btn btn-primary">Actualizar</button>
            </form>
        </div>
    </div>
</div>
