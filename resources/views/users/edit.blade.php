@extends('layouts.app')

@section('content')
    <div class="container">
        <h2>Editar Usuario</h2>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Nueva Contraseña (opcional)</label>
                <input type="password" name="password" class="form-control">
            </div>

            <div class="mb-3">
                <label>Rol</label>
                <select name="roles_id" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->roles_id == $role->id ? 'selected' : '' }}>
                            {{ $role->nombre_rol }}
                        </option>
                    @endforeach
                </select>
            </div>

            <button class="btn btn-success">Actualizar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </form>
    </div>
@endsection
