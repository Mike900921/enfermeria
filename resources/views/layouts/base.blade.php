<!DOCTYPE html>
<html lang="en">

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
    .nav-link.text-dark:hover {
        background-color: #cccccc;
        border-radius: 5px;
    }

    .btn-azul {
        background-color: #00304d;
        color: white;
        border-radius: 5px;
    }

    .btn-azul-claro {
        background-color: #50E5F9;
        color: white;
        border-radius: 5px;
    }

    .btn-verde {
        background-color: #007832;
        color: white;
        border-radius: 5px;
    }

    .btn-morado {
        background-color: #71277a;
        color: white;
        border-radius: 5px;
    }

    .btn-amarillo {
        background-color: #fdc300;
        color: black;
        border-radius: 5px;
    }

    /* Hover opcional */
    .btn-azul:hover {
        background-color: #004d7a;
    }

    .btn-azul-claro:hover {
        background-color: #50E5F9;
    }

    .btn-verde:hover {
        background-color: #009944;
    }

    .btn-morado:hover {
        background-color: #8e3299;
    }

    .btn-amarillo:hover {
        background-color: #ffdb4d;
    }

    .bg-azul-claro {
        background-color: #50e5f957;
        color: white;
        border-radius: 5px;
    }

    .bg-verde {
        background-color: #007832;
        color: white;
        border-radius: 5px;
    }

    .bg-azul {
        background-color: #002f4dd3;
        color: white;
        border-radius: 5px;
    }

    .bg-morado {
        background-color: #71277a;
        color: white;
        border-radius: 5px;
    }


    .border-verde {
        border: 1px solid #007832 !important;
    }

    .border-azul-claro {
        border: 1px solid #50e5f957 !important;
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
            <button onclick="toggleMenu()">☰</button>
            <h3>Consultas enfermería</h3>
        </div>

        <div>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle d-flex align-items-center" data-bs-toggle="dropdown"
                    title="{{ auth()->user()->name }}">

                    <!-- Avatar de letra -->
                    <div class="letter-avatar me-2">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                </a>

                <ul class="dropdown-menu dropdown-menu-end">

                    <!--  Cambiar contraseña -->
                    <li>
                        <a class="dropdown-item" href="#" data-bs-toggle="modal"
                            data-bs-target="#changePasswordModal">
                            <i class="fas fa-key me-2 text-primary"></i> Cambiar contraseña
                        </a>
                    </li>

                    <li>
                        <hr class="dropdown-divider">
                    </li>

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
            </li>
        </div>
    </header>

    <!-- Sidebar y contenido -->

    <div class="layout">
        <!-- Sidebar -->
        <nav id="sidebar" class="sidebar">
            <ul class="nav flex-column">
                @can('gestionar-usuarios')
                    <li class="nav-item mb-0 border-bottom">
                        <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('users.index') ? 'active bg-success text-white' : '' }}"
                            href="{{ route('users.index') }}" title="Usuarios">
                            <i class="bi bi-people-fill me-2"></i>
                            <span class="sidebar-text">Usuarios</span>
                        </a>
                    </li>
                @endcan
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('consulta.index') ? 'active bg-success text-white' : '' }}"
                        href="{{ route('consulta.index') }}" title="Consulta">
                        <i class="bi bi-person-check-fill me-2"></i>
                        <span class="sidebar-text">Consulta</span>
                    </a>
                </li>
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('registros.index') ? 'active bg-success text-white' : '' }}"
                        href="{{ route('registros.index') }}" title="Atenciones">
                        <i class="bi bi-journal-text me-2"></i>
                        <span class="sidebar-text">Atenciones</span>
                    </a>
                </li>
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('caracterizacion') ? 'active bg-success text-white' : '' }}"
                        href="{{ route('caracterizacion') }}" title="Encuesta">
                        <i class="bi bi-card-checklist me-2"></i>
                        <span class="sidebar-text">Encuesta</span>
                    </a>
                </li>
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('estadisticas.index') ? 'active bg-success text-white' : '' }}"
                        href="{{ route('estadisticas.index') }}" title="Estadistica">
                        <i class="bi bi-bar-chart  me-2"></i>
                        <span class="sidebar-text">Estadistica</span>
                    </a>
                </li>
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center {{ request()->routeIs('motivos.index') ? 'active bg-success text-white' : '' }}"
                        href="{{ route('motivos.index') }}" title="About">
                        <i class="bi bi-gear me-2"></i>
                        <span class="sidebar-text">Motivos</span>
                    </a>
                </li>
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
                    <div class="modal-header">
                        <h5 class="modal-title" id="changePasswordModalLabel">Cambiar contraseña</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal"
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
