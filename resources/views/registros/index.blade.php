@extends('layouts.base')

@section('content')
    <div class="container user-select-none">
        <h2>Atenciones Registradas</h2>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                {{ session('error') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif



        {{-- Filtros de búsqueda por fecha, tipo de documento, edad y texto --}}
        <div class="row g-2 mb-2 buscador align-items-end">
            <div class="col-12 col-md-2">
                <label for="fecha_inicio" class="form-label mb-1">Fecha desde</label>
                <input id="fecha_inicio" type="date" class="form-control" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Desde" aria-label="Desde">
            </div>

            <div class="col-12 col-md-2">
                <label for="fecha_fin" class="form-label mb-1">Fecha hasta</label>
                <input id="fecha_fin" type="date" class="form-control" data-bs-toggle="tooltip"
                    data-bs-placement="top" title="Hasta" aria-label="Hasta">
            </div>

            <div class="col-12 col-md-2">
                <label for="tipo_documento" class="form-label mb-1">Tipo de documento</label>
                <select id="tipo_documento" class="form-select" aria-label="Tipo de documento">
                    <option value="">Todos</option>
                    @foreach ($tiposDocumentos ?? [] as $tipoDocumento)
                        <option value="{{ $tipoDocumento['valor'] }}">{{ $tipoDocumento['texto'] }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12 col-md-2">
                <label for="filtro_edad" class="form-label mb-1">Edad</label>
                <select id="filtro_edad" class="form-select" aria-label="Filtro por edad">
                    <option value="">Todas</option>
                    <option value="menor_18">Menor de 18 años</option>
                    <option value="mayor_18">Mayor o igual a 18 años</option>
                </select>
            </div>

            <div class="col-12 col-md-4">
                <label for="input-busqueda" class="form-label mb-1">Búsqueda</label>
                <div class="d-flex gap-2">
                    <input id="input-busqueda" type="search" class="form-control" placeholder="Paciente, doc o enfermero" />
                    <button id="btn-buscar" class="btn btn-outline-success d-flex align-items-center" type="button">
                        <i class="bi bi-search me-1"></i>Buscar
                    </button>
                </div>
            </div>
        </div>

        {{-- Tabla de pacientes --}}
        <div id="tabla-pacientes" class="mt-5">
            @include('registros.partials.tablaRegistro')
        </div>
    </div>

    {{-- Variables de rutas para el script de búsqueda y descarga --}}
    <script>
        const URL_REGISTROS = "{{ route('registros.index') }}";
        const URL_EXCEL = "{{ route('atenciones.export') }}";
    </script>

    <!-- Incluir el script del buscador de public/js/BuscadorRegistro.js -->
    <script src="{{ asset('js/BuscadorRegistro.js') }}"></script>

    <script>
        // Tooltips de Bootstrap para "Desde / Hasta"
        const tooltipTriggerList = document.querySelectorAll('[data-bs-toggle="tooltip"]');
        [...tooltipTriggerList].forEach((el) => new bootstrap.Tooltip(el));
    </script>
@endsection
