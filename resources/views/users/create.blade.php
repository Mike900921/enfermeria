@extends('layouts.app')

@section('content')
<div class="container">
    <h2>Crear Usuario</h2>

    <form action="{{ route('users.store') }}" method="POST">
        @csrf

        <div class="mb-3">
            <label>Nombre</label>
            <input type="text" name="name" class="form-control" required>
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
            <label>Rol</label>
            <select name="role" class="form-control">
                <option value="admin">Administrador</option>
                <option value="enfermeria">Enfermería</option>
            </select>
        </div>

        <button class="btn btn-success">Guardar</button>
        <a href="{{ route('users.index') }}" class="btn btn-secondary">
            Volver
        </a>
    </form>
</div>
@endsection