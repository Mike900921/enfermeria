@extends('layouts.base')

@section('content')
    <style>
        .alert-small {
            align-items: center;
            text-align: center;
            padding: 0.25rem 0.5rem;
            font-size: 0.8rem;
            border-radius: 0.25rem;
            position: fixed;
            min-width: 250px;
            /* ancho mínimo decente */
            max-width: 90%;
        }
    </style>

    <div class="container user-select-none">
        <h2>Listado de Usuarios</h2>

        <a href="{{ route('users.create') }}" class="btn btn-primary mb-3">
            <i class="bi bi-person-add"></i> Crear Usuario
        </a>

        @if (session('success') || session('error'))
            <div
                style="
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            width: auto;
            max-width: 90%;
        ">
                <div class="alert alert-dismissible fade show shadow-lg border-0 {{ session('success') ? 'alert-success' : 'alert-danger' }}"
                    role="alert" style="border-radius: 20px; padding-right: 50px;">
                    @if (session('success'))
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                    @else
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                    @endif
                </div>
            </div>
        @endif


        <div class="">
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
            <div class="border rounded-4 overflow-hidden shadow-sm">
                <table class="table table-striped table-hover align-middle mb-0">

                    <thead class="table-light">
                        <tr>
                            <th><i class="bi bi-person"></i> Nombre de Usuario</th>
                            <th><i class="bi bi-envelope"></i> Email</th>
                            <th><i class="bi bi-shield"></i> Rol</th>
                            <th><i class="bi bi-info-circle"></i> Estado</th>
                            <th><i class="bi bi-gear"></i> Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                            <tr @if ($user->trashed()) class="table-secondary" @endif>
                                <td>{{ $user->name }} {{ $user->last_name }}</td>
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
                                        <i class="bi bi-pencil-square"></i> Editar
                                    </a>

                                    @if ($user->trashed())
                                        <!-- Botón para restaurar -->
                                        <form action="{{ route('users.restore', $user->user_id) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            <button class="btn btn-success btn-sm"
                                                onclick="return confirm('¿Restaurar usuario?')">
                                                <i class="bi bi-person-check-fill"></i> Restaurar
                                            </button>
                                        </form>
                                    @else
                                        <!-- Botón para inhabilitar -->
                                        <form action="{{ route('users.destroy', $user) }}" method="POST"
                                            style="display:inline;">
                                            @csrf
                                            @method('DELETE')
                                            <button class="btn btn-danger btn-sm"
                                                onclick="return confirm('¿Inhabilitar usuario?')">
                                                <i class="bi bi-person-fill-slash"></i> Inhabilitar
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @if ($users->hasPages())
                <div class="d-flex justify-content-center mt-3">
                    {{ $users->links('pagination::bootstrap-5') }}
                </div>
            @endif
        </div>

    </div>

    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert-danger, .alert-success');
            if (alert) alert.style.display = 'none';
        }, 5000); // 5 segundos
    </script>
@endsection
