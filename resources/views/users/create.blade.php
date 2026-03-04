@extends('layouts.base')

@section('content')
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <div class="container">
        <h2>Crear Usuario</h2>

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label>Nombre</label>
                <input type="text" name="name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Apellido</label>
                <input type="text" name="last_name" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Ciudad</label>
                <input type="text" name="city" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Teléfono</label>
                <input type="text" name="phone_number" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Email</label>
                <input type="email" name="email" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Contraseña</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Confirmar Contraseña</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <div class="mb-3">
                <label>Rol</label>
                <select name="roles_id" class="form-control">
                    <option value="1">Administrador</option>
                    <option value="2">Enfermería</option>
                </select>
            </div>

            <button class="btn btn-success">Guardar</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">
                Volver
            </a>
        </form>
    </div>
@endsection
