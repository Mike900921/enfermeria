@extends('layouts.base')

@section('content')
    <div class="container user-select-none">

        <h2>Crear Usuario</h2>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf
            <div class="d-flex row gap-3">
                <div class="mb-1 position-relative">
                    <label><i class="bi bi-person"></i> Nombre <span class="text-danger">*</span></label>
                    <input type="text" name="name" class="form-control" required value="{{ old('name') }}">
                    @error('name')
                        <div class="text-danger small position-absolute">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-1 position-relative">
                    <label><i class="bi bi-person"></i> Apellido <span class="text-danger">*</span></label>
                    <input type="text" name="last_name" class="form-control" required value="{{ old('last_name') }}">
                    @error('last_name')
                        <div class="text-danger small position-absolute">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-1 position-relative">
                    <label><i class="bi bi-telephone"></i> Teléfono <span class="text-danger">*</span></label>
                    <input type="tel" name="phone_number" class="form-control" required
                        value="{{ old('phone_number') }}">
                    @error('phone_number')
                        <div class="text-danger small position-absolute">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-1 position-relative">
                    <label><i class="bi bi-envelope"></i> Email <span class="text-danger">*</span></label>
                    <input type="email" name="email" class="form-control" required value="{{ old('email') }}">
                    @error('email')
                        <div class="text-danger small position-absolute">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-1 position-relative">
                    <label><i class="bi bi-shield"></i> Rol <span class="text-danger">*</span></label>
                    <select name="roles_id" class="form-control">
                        @foreach ($roles as $role)
                            <option value="{{ $role->id }}" {{ $user->role_id == $role->id ? 'selected' : '' }}>
                                {{ $role->nombre_rol }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="mb-1 position-relative">
                    <label><i class="bi bi-key"></i> Contraseña <span class="text-danger">*</span></label>
                    <input type="password" name="password" class="form-control" required
                        pattern="(?=.*[A-Z])(?=.*[!@#$%^&*()_\-+=.]).{6,}"
                        title="La contraseña debe tener al menos 6 caracteres, una mayúscula y un carácter especial">
                    @error('password')
                        <div class="text-danger small position-absolute">{{ $message }}</div>
                    @enderror
                </div>

                <div class="mb-1 position-relative">
                    <label><i class="bi bi-key"></i> Confirmar Contraseña <span class="text-danger">*</span></label>
                    <input type="password" name="password_confirmation" class="form-control" required>
                    @error('password_confirmation')
                        <div class="text-danger small position-absolute">{{ $message }}</div>
                    @enderror
                </div>

                <div>
                    <button class="btn btn-success">Guardar</button>
                    <a href="{{ route('users.index') }}" class="btn btn-secondary">
                        Volver
                    </a>
                </div>
            </div>
        </form>
    </div>
@endsection
