@extends('layouts.base')

@section('content')

<style>
    .buscador {
        justify-content: center;
        align-items: center;
        display: flex;
    }
</style>
<div class="container ">
    <div class="row">
        <div class="col-12">
            <div class="row  buscador">
                <div class="col-4">
                    <h1 class="text-center mt-4 fw-bold">Lista Motivos</h1>
                </div>
                <div class="col  pt-4">
                    <form method="GET" action="{{ route('motivos.index') }}" class="mb-3 d-flex align-items-center gap-2">
                        <label for="filter">Filtrar:</label>
                        <select name="filter" id="filter" class="form-select w-auto" onchange="this.form.submit()">
                            <option value="todo"@selected(request('filter') == 'todo')">Todos</option>
                            <option value="activos" @selected(request('filter') == 'activos')">Activos</option>
                            <option value="inactivos" @selected(request('filter') == 'inactivos')">Inactivos</option>
                        </select>
                    </form>
                </div>
                <div class="col-4 text-center  buscador pt-4">
                    <input type="text" id="buscarMotivo" name="buscarMotivo" class="form-control mb-3" placeholder="Buscar motivo...">
                </div>
                <div class="col-2 text-center  buscador">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="bi bi-plus-lg me-1"></i> Crear motivo
                    </button>
                    <x-modal-motivos.crear-motivo /> <!-- Aquí se incluye el componente del modal -->
                </div>
            </div>
            <div id="resultados" class="mb-3">
                <!-- Aquí se mostrarán los resultados de la búsqueda -->
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
        </div>
    </div>
</div>

<script>
    let timeout = null;

    document.getElementById('buscarMotivo').addEventListener('keyup', function() {
        clearTimeout(timeout);

        let query = this.value;

        timeout = setTimeout(() => {
            fetch(`/buscarMotivos?q=${query}`)
                .then(response => response.text())
                .then(data => {
                    document.getElementById('resultados').innerHTML = data;
                });
        }, 200);
    });
</script>
@endsection