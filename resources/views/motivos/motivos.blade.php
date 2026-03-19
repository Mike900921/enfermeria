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
                <div class="col-3 text-center  buscador">
                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                        <i class="bi bi-plus-lg me-1"></i> Crear motivo
                    </button>
                    <x-modal-motivos.crear-motivo /> <!-- Aquí se incluye el componente del modal -->
                </div>
                <div class="col-5">
                    <h1 class="text-center mt-4 fw-bold">Lista Motivos</h1>
                </div>

                <div class="col-4 text-center  buscador pt-4">
                    <input type="text" id="buscarMotivo" name="buscarMotivo" class="form-control mb-3" placeholder="Buscar motivo...">
                </div>
            </div>

            <div id="resultados" class="mb-3 mt-3 d-flex justify-content-center align-items-center">

                <!-- Aquí se mostrarán los resultados de la búsqueda -->
                <div class="border rounded-4 overflow-hidden shadow-sm " style="width: fit-content; min-width: 600px;">
                    <table class="table table-bordered text-center w-auto m-0 border table-striped">
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