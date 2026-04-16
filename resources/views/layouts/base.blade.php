<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script> <!-- jQuery -->
    <!-- Estilos personalizados para el topbar -- Ruta = public/css/topbar.css -->
    <link rel="stylesheet" href="{{ asset('css/topbar.css') }}">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/png" href="{{ asset('img/logoSena.png') }}">
    <!-- Tom Select CSS -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.bootstrap5.min.css" rel="stylesheet">
    <title>Enfermería</title>
</head>

<style>
    .nav-link .text-dark:hover {
        background-color: #e2f6fb;
        border-radius: 5px;
    }

    .nav-link.active {
        background-color: #00304d !important;
        color: #fff !important;
        border-radius: 8px;
    }

    .topbar .brand-logo {
        height: 34px;
        width: auto;
        filter: brightness(0) invert(1);
        opacity: 0.95;
    }

    .topbar .brand-sep {
        width: 1px;
        height: 28px;
        background: rgba(255, 255, 255, 0.25);
        margin: 0 12px;
    }

    .btn-azul {
        background-color: #00304d;
        color: white;
        border-radius: 5px;
    }

    .btn-azul-claro {
        background-color: #50E5F9;
        color: #00304d;
        border-radius: 5px;
    }

    .btn-azul-oscuro {
        background-color: #00253a;
        color: white;
        border-radius: 5px;
    }

    .btn-azul:hover {
        background-color: #004d7a;
    }

    .btn-azul-claro:hover {
        background-color: #7ff0ff;
    }

    .btn-azul-oscuro:hover {
        background-color: #003b5c;
    }

    /* Alias para estilos antiguos (mantiene funcionalidad, cambia look a azul) */
    .btn-verde {
        background-color: #00304d;
        color: #fff;
        border-radius: 8px;
    }

    .btn-verde:hover {
        background-color: #004d7a;
        color: #fff;
    }

    .bg-verde {
        background-color: #00304d !important;
        color: #fff !important;
    }

    .border-verde {
        border: 1px solid #00304d !important;
    }

    /* Re-map Bootstrap "success" a azul institucional */
    .text-success {
        color: #00304d !important;
    }

    .btn-success {
        background-color: #00304d;
        border-color: #00304d;
    }

    .btn-success:hover {
        background-color: #004d7a;
        border-color: #004d7a;
    }

    .btn-outline-success {
        color: #00304d;
        border-color: #00304d;
    }

    .btn-outline-success:hover {
        background-color: #00304d;
        border-color: #00304d;
        color: #fff;
    }

    /* Botones puntuales verdes (ej: Descargar Excel) */
    .btn-sena-verde {
        background-color: #007832;
        color: #fff;
        border-radius: 8px;
        border: 1px solid #007832;
    }

    .btn-sena-verde:hover {
        background-color: #009944;
        border-color: #009944;
        color: #fff;
    }

    /* Botones específicos solicitados en Atenciones */
    .btn-registrar-atencion {
        background-color: #2A9D8F;
        color: #fff;
        border: 1px solid #2A9D8F;
        border-radius: 8px;
    }

    .btn-registrar-atencion:hover {
        background-color: #21867A;
        border-color: #21867A;
        color: #fff;
    }

    .btn-ver-informacion {
        background-color: rgb(42, 100, 139);
        color: #fff;
        border: 1px solid rgb(42, 100, 139);
        border-radius: 8px;
    }

    .btn-ver-informacion:hover {
        background-color: rgb(31, 77, 107);
        border-color: rgb(31, 77, 107);
        color: #fff;
    }

    .btn-ver-registro {
        background-color: #6C8EA4;
        color: #fff;
        border: 1px solid #6C8EA4;
        border-radius: 8px;
    }

    .btn-ver-registro:hover {
        background-color: #5A788C;
        border-color: #5A788C;
        color: #fff;
    }

    .header-institucional {
        background: linear-gradient(90deg, #00304d 0%, #003b5c 100%);
        color: #fff;
        border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Por encima de .content h1–h6 (títulos oscuros) */
    .header-institucional h1,
    .header-institucional h2,
    .header-institucional h3,
    .header-institucional h4,
    .header-institucional h5,
    .header-institucional h6 {
        color: #fff !important;
        margin-bottom: 0;
    }

    .card {
        border-radius: 16px;
        border-color: #d8e6ee;
    }

    .card-header {
        border-top-left-radius: 16px;
        border-top-right-radius: 16px;
    }

    .card-header h4 {
        margin-bottom: 0 !important;
    }

    /* Encabezados de tarjetas de datos (paciente, ficha, etc.) */
    .card-header.bg-azul-claro,
    .card-header.bg-azul,
    .card-header.bg-verde {
        background-color: #4e8e9e !important;
        color: #ffffff !important;
        border-bottom: 1px solid rgba(0, 0, 0, 0.05);
    }

    .table-success {
        --bs-table-bg: #e2f6fb;
        --bs-table-striped-bg: #d3f1f8;
        --bs-table-striped-color: #0b2230;
        --bs-table-color: #0b2230;
        --bs-table-border-color: #c7e4ee;
    }

    /* Títulos globales del contenido */
    .content h1,
    .content h2,
    .content h3,
    .content h4,
    .content h5,
    .content h6 {
        color: #00253a;
        font-weight: 700;
        letter-spacing: 0.2px;
        margin-bottom: 0.85rem;
        text-wrap: balance;
    }

    .modal-title {
        color: white !important;
        margin-bottom: 0 !important;
    }

    .content h1 {
        font-size: clamp(1.9rem, 2.2vw, 2.35rem);
    }

    .content h2 {
        font-size: clamp(1.6rem, 1.9vw, 2rem);
    }

    .content h3 {
        font-size: clamp(1.3rem, 1.5vw, 1.6rem);
    }

    .content .modal-title,
    .content .card-header {
        font-weight: 700;
        letter-spacing: 0.2px;
    }

    .bg-azul-claro {
        background-color: #e2f6fb;
        color: #00304d;
        border-radius: 5px;
    }

    .bg-azul {
        background-color: #00304d;
        color: white;
        border-radius: 5px;
    }

    .border-azul {
        border: 1px solid #00304d !important;
    }

    .border-azul-claro {
        border: 1px solid #4e8e9e !important;
    }

    .user-menu-toggle {
        min-width: 0;
        max-width: 100%;
    }

    .user-fullname {
        cursor: pointer;
        display: inline-block;
        min-width: 0;
        max-width: 100%;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    @media (max-width: 576px) {
        .user-menu-toggle {
            max-width: 62vw;
        }

        .user-fullname {
            max-width: 42vw;
        }

        .user-menu-toggle.hide-name-mobile .user-fullname {
            display: none;
        }

        .user-menu-toggle.hide-name-mobile .letter-avatar {
            margin-right: 0 !important;
        }
    }
</style>

<body>
    {{-- Script para recordar estado del sidebar --}}
    <script id="a3x9vd">
        if (localStorage.getItem("sidebarClosed") === "true") {
            document.documentElement.classList.add("sidebar-closed");
        }
    </script>

    <header class="topbar d-flex justify-content-between align-items-center">
        <div class="menu user-select-none">
            <button onclick="toggleMenu()" aria-label="Abrir menú">☰</button>
            <h3 class="m-0">Consultas enfermería</h3>
        </div>

        <div>
            @php
                $user = Auth::guard('instructor')->check() ? Auth::guard('instructor')->user() : Auth::user();

                $fullName = $user->full_name;
                $isLongUserName = \Illuminate\Support\Str::length($fullName) > 22;
            @endphp

            <a class="nav-link dropdown-toggle d-flex align-items-center user-menu-toggle {{ $isLongUserName ? 'hide-name-mobile' : '' }}"
                data-bs-toggle="dropdown" title="{{ $fullName }}">

                <!-- Avatar de letra -->
                <div class="letter-avatar me-2">
                    {{ strtoupper(substr($fullName, 0, 1)) }}
                </div>
                <div class="me-2 text-white user-fullname">
                    {{ $fullName }}
                </div>
            </a>

            <ul class="dropdown-menu dropdown-menu-end">

                <!--  Cambiar contraseña -->

                @canany(['gestionar-usuarios', 'gestionar-responsable'])
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-2 text-primary"></i> Cambiar contraseña
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>
                @endcanany

                <!--  Cerrar sesión -->
                <li>
                    <a class="dropdown-item" href="{{ route('logout') }}"
                        onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2 text-danger"></i> Cerrar sesión
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </div>
    </header>

    <!-- Sidebar y contenido -->
    <div class="layout">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <div class="sidebar-brand">
                <img src="{{ asset('img/logo-sena-blanco.png') }}" alt="SENA" />
            </div>
            <ul class="nav flex-column">

                @can('gestionar-usuarios')
                    <li class="nav-item mb-0 border-bottom">
                        <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('users.index') ? 'active' : '' }}"
                            href="{{ route('users.index') }}" title="Usuarios">
                            <i class="bi bi-people-fill me-2"></i>
                            <span class="sidebar-text">Usuarios</span>
                        </a>
                    </li>
                @endcan

                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('consulta.index') ? 'active' : '' }}"
                        href="{{ route('consulta.index') }}" title="Consulta">
                        <i class="bi bi-person-check-fill me-2"></i>
                        <span class="sidebar-text">Consulta</span>
                    </a>
                </li>


                @canany(['gestionar-usuarios', 'gestionar-responsable'])
                    <li class="nav-item mb-0 border-bottom">
                        <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('registros.index') ? 'active' : '' }}"
                            href="{{ route('registros.index') }}" title="Atenciones">
                            <i class="bi bi-journal-text me-2"></i>
                            <span class="sidebar-text">Atenciones</span>
                        </a>
                    </li>
                @endcanany

                @canany(['gestionar-usuarios', 'gestionar-responsable'])
                    <li class="nav-item mb-0 border-bottom">
                        <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('caracterizacion') ? 'active' : '' }}"
                            href="{{ route('caracterizacion') }}" title="Encuesta">
                            <i class="bi bi-card-checklist me-2"></i>
                            <span class="sidebar-text">Encuesta</span>
                        </a>
                    </li>
                @endcanany


                @canany(['gestionar-usuarios', 'gestionar-responsable'])
                    <li class="nav-item mb-0 border-bottom">
                        <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('estadisticas.index') ? 'active' : '' }}"
                            href="{{ route('estadisticas.index') }}" title="Estadistica">
                            <i class="bi bi-bar-chart  me-2"></i>
                            <span class="sidebar-text">Estadistica</span>
                        </a>
                    </li>
                @endcanany

                @canany(['gestionar-usuarios', 'gestionar-responsable'])
                    <li class="nav-item mb-0 border-bottom">
                        <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('motivos.index') ? 'active' : '' }}"
                            href="{{ route('motivos.index') }}" title="About">
                            <i class="bi bi-gear me-2"></i>
                            <span class="sidebar-text">Motivos</span>
                        </a>
                    </li>
                @endcanany
            </ul>
        </nav>

        <!-- Contenido principal -->
        <main class="content w-100 h-auto fondo-global ">

            {{-- Alertas de éxito o errores --}}
            @if (session('success') || session('error') || $errors->any())
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
                    {{-- Mensaje de éxito --}}
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible fade show shadow-lg border-0" role="alert"
                            style="border-radius: 20px; padding-right: 50px;">
                            <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        </div>
                    @endif

                    {{-- Mensajes de error --}}
                    @if ($errors->any())
                        @foreach ($errors->all() as $error)
                            <div class="alert alert-danger alert-dismissible fade show shadow-lg border-0"
                                role="alert" style="border-radius: 20px; padding-right: 50px;">
                                <i class="fas fa-exclamation-circle me-2"></i> {{ $error }}
                            </div>
                        @endforeach
                    @endif

                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible fade show shadow-lg border-0" role="alert"
                            style="border-radius: 20px; padding-right: 50px;">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        </div>
                    @endif
                </div>
            @endif

            <div class="fondo-logo">
                <img src="/img/logoSena.png" alt="Logo" />
            </div>
            <div style="position: relative;">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Modal Cambiar Contraseña -->
    <div class="modal fade" id="changePasswordModal" tabindex="-1" aria-labelledby="changePasswordModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">

                <form action="{{ route('password.update') }}" method="POST">
                    @csrf
                    <div class="modal-header" style="background-color: #00253a">
                        <h5 class="modal-title" id="changePasswordModalLabel">Cambiar contraseña</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                            aria-label="Cerrar"></button>
                    </div>

                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="current_password" class="form-label">Contraseña actual</label>
                            <input type="password" name="current_password" id="current_password"
                                class="form-control" required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password" class="form-label">Nueva contraseña</label>
                            <input type="password" name="new_password" id="new_password" class="form-control"
                                required>
                        </div>

                        <div class="mb-3">
                            <label for="new_password_confirmation" class="form-label">Confirmar nueva
                                contraseña</label>
                            <input type="password" name="new_password_confirmation" id="new_password_confirmation"
                                class="form-control" required>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                        <button type="submit" class="btn btn-primary">Actualizar contraseña</button>
                    </div>
                </form>

            </div>
        </div>
    </div>

    <!-- Incluir el script para el topbar desde public/js/topbar.js -->
    <script src="{{ asset('js/topbar.js') }}"></script>
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>

    {{-- Script para el toggle del sidebar --}}
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('mainContent');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
        });
    </script>

    {{-- script para ocultar alertas de mensajes automaticamente --}}
    <script>
        setTimeout(() => {
            const alert = document.querySelector('.alert-danger, .alert-success');
            if (alert) alert.style.display = 'none';
        }, 5000); // 5 segundos
    </script>
</body>


</html>
