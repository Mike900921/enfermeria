@extends('layouts.base')

@section('content')
    <div class="container">
        <h2>Listado de Usuarios</h2>

        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
            Crear Usuario
        </a>

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif
        @if (session('error'))
            <div class="alert alert-danger">
                {{ session('error') }}
            </div>
        @endif

        <div>
            <form method="GET" action="{{ route('users.index') }}" class="mb-3 d-flex align-items-center gap-2">
                <label for="filter">Filtrar:</label>
                <select name="filter" id="filter" class="form-select w-auto" onchange="this.form.submit()">
                    <option value="todo" {{ $filter === 'todo' ? 'selected' : '' }}>Todos</option>
                    <option value="activos" {{ $filter === 'activos' ? 'selected' : '' }}>Activos</option>
                    <option value="inactivos" {{ $filter === 'inactivos' ? 'selected' : '' }}>Inactivos</option>
                </select>
            </form>
        </div>

        <table class="table table-striped table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Rol</th>
                    <th>Estado</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr @if ($user->trashed()) class="table-secondary" @endif>
                        <td>{{ $user->name }}</td>
                        <td>{{ $user->email }}</td>
                        <td>{{ $user->roles->nombre_rol }}</td>
                        <td>
                            @if ($user->trashed())
                                Inactivo
                            @else
                                Activo
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('users.edit', $user) }}" class="btn btn-amarillo btn-sm">
                                Editar
                            </a>

                            @if ($user->trashed())
                                <!-- Botón para restaurar -->
                                <form action="{{ route('users.restore', $user->user_id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    <button class="btn btn-success btn-sm" onclick="return confirm('¿Restaurar usuario?')">
                                        Restaurar
                                    </button>
                                </form>
                            @else
                                <!-- Botón para inhabilitar -->
                                <form action="{{ route('users.destroy', $user) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-danger btn-sm" onclick="return confirm('¿Inhabilitar usuario?')">
                                        Inhabilitar
                                    </button>
                                </form>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        @if ($users->hasPages())
            <div class="d-flex justify-content-center mt-3">
                {{ $users->links('pagination::bootstrap-5') }}
            </div>
        @endif
    </div>
@endsection
