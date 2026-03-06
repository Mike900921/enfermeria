<table class="table table-striped table-hover align-middle">
    <thead class="table-light">
        <tr>
            <th>ID</th>
            <th>Paciente</th>
            <th>Usuario</th>
            <th>Fecha y Hora</th>
            <th>Motivo</th>
            <th>Procedimientos</th>
            <th>Observaciones</th>
            <th>Accion</th>
        </tr>
    </thead>
    <tbody>
        @forelse ($atenciones as $atencion)
            <tr>
                <td>{{ $atencion->id }}</td>
                <td>{{ $atencion->paciente->par_nombres }}</td>
                <td>{{ $atencion->usuario->name }}</td>
                <td>{{ $atencion->fecha_hora }}</td>
                <td>{{ $atencion->motivo }}</td>
                <td>{{ $atencion->procedimientos }}</td>
                <td>{{ $atencion->observaciones }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="8" class="text-center">No hay resultados</td>
            </tr>
        @endforelse
    </tbody>
</table>
