
<div class="border rounded-4 overflow-hidden shadow-sm " style="width: fit-content; min-width: 600px;">
    <table class="table table-bordered text-center  m-0 border table-striped">
        <thead>
            <tr>
                <th style="width: 10%; white-space: nowrap; text-align: center;">ID</th>
                <th style="width: 20%; white-space: nowrap; text-align: center;">Motivo</th>
                <th style="width: 20%; white-space: nowrap; text-align: center;">Acciones</th>
            </tr>
        </thead>
        <tbody>
            @foreach($motivos as $motivo)
            <tr>
                <td>{{ $motivo->id }}</td>
                <td>{{ $motivo->motivo }}</td>
                <td>
                    <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#editarMotivoModal{{ $motivo->id }}">Editar</button>
                </td>
            </tr>
            <!-- Aquí se incluye el componente del modal para editar, pasando el motivo actual -->
            @include('components.modal-motivos.editar-motivo', ['motivo' => $motivo])
            @endforeach
        </tbody>
    </table>
</div>