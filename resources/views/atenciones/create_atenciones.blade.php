@extends('layouts.base')

@section('content')
    <div class="container">
        <h3 class="mb-4">Registrar Atención</h3>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('atenciones.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Paciente</label>
                <select name="paciente_id" class="form-control" required>
                    <option value="">Seleccione un paciente</option>

                    @foreach ($pacientes as $p)
                        <option value="{{ $p->par_identificacion }}">
                            {{ $p->par_identificacion }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Fecha y Hora</label>
                <input type="datetime-local" name="fecha_hora" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Motivo</label>
                <textarea name="motivo" class="form-control" required></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Procedimientos</label>
                <textarea name="procedimientos" class="form-control"></textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Observaciones</label>
                <textarea name="observaciones" class="form-control"></textarea>
            </div>

            <button type="submit" class="btn btn-primary">
                Registrar Atención
            </button>
        </form>
    </div>
@endsection
