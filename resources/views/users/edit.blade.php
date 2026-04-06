@extends('layouts.base')

@section('content')
    <div class="container">
        <h2>Editar Usuario</h2>

        <form action="{{ route('users.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label><i class="bi bi-person"></i> Nombre</label>
                <input type="text" name="name" value="{{ $user->name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label><i class="bi bi-person"></i> Apellido</label>
                <input type="text" name="last_name" value="{{ $user->last_name }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label><i class="bi bi-telephone"></i> Número de Teléfono</label>
                <input type="text" name="phone_number" value="{{ $user->phone_number }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label><i class="bi bi-envelope"></i> Email</label>
                <input type="email" name="email" value="{{ $user->email }}" class="form-control" required>
                @error('email')
                    <div class="text-danger small position-absolute">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label><i class="bi bi-lock"></i> Nueva Contraseña</label>
                <input type="password" name="password" class="form-control" placeholder="Dejar vacío si no desea cambiarla">
                @error('password')
                    <div class="text-danger small position-absolute">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label><i class="bi bi-lock"></i> Confirmar Nueva Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control">
            </div>

            <div class="mb-3">
                <label><i class="bi bi-shield"></i> Rol</label>
                <select name="roles_id" class="form-control">
                    @foreach ($roles as $role)
                        <option value="{{ $role->id }}" {{ $user->roles_id == $role->id ? 'selected' : '' }}>
                            {{ $role->nombre_rol }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button class="btn btn-azul">Actualizar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </form>
    </div>
@endsection
