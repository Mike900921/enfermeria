@extends('layouts.base')

@section('content')
    <div class="container user-select-none">
        <h2>Atenciones Registradas</h2>


        {{-- Filtros de búsqueda por fecha, nombre paciente, cedula y nombre enfermero que lo atendio --}}
        <div class="d-flex mb-2 buscador">
            <input id="fecha_inicio" type="date" class="form-control me-2" placeholder="Fecha inicio" title="Fecha inicio">
            <input id="fecha_fin" type="date" class="form-control me-2" placeholder="Fecha fin" title="Fecha fin">
            <input id="input-busqueda" type="search" class="form-control me-2" placeholder="Buscar Paciente..." />
            <button id="btn-buscar" class="btn btn-outline-success d-flex" type="button"><i
                    class="bi bi-search me-1"></i>Buscar
            </button>
        </div>


        {{-- Botón para descargar registro en Excel --}}
        <a id="btn-excel" href="{{ route('atenciones.export') }}" class="btn btn-success ms-2">
            <i class="bi bi-file-earmark-excel"></i> Descargar Excel
        </a>

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
@endsection
