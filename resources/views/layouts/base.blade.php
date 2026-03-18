<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/topbar.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <title>Document</title>
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
    <script id="a3x9vd">
        if (localStorage.getItem("sidebarClosed") === "true") {
            document.documentElement.classList.add("sidebar-closed");
        }
    </script>
    <header class="topbar d-flex justify-content-between align-items-center">
        <div class="menu">
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
    <div class="layout ">
        <nav id="sidebar" class="sidebar">
            <ul class="nav flex-column">
                @can('gestionar-usuarios')
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('users.index') }}"
                        title="Usuarios">
                        <i class="bi bi-people-fill me-2"></i>
                        <span class="sidebar-text">Usuarios</span>
                    </a>
                </li>
                @endcan
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('consulta.index') }}"
                        title="Aprendices">
                        <i class="bi bi-person-check-fill me-2"></i>
                        <span class="sidebar-text">Aprendices</span>
                    </a>
                </li>
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('registros.index') }}"
                        title="Atenciones">
                        <i class="bi bi-journal-text me-2"></i>
                        <span class="sidebar-text">Atenciones</span>
                    </a>
                </li>
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('caracterizacion') }}">
                        <i class="bi bi-card-checklist me-2"></i>
                        <span class="sidebar-text">Encuesta</span>
                    </a>
                </li>
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('estadisticas.index') }}"
                        title="Estadistica">
                        <i class="bi bi-bar-chart  me-2"></i>
                        <span class="sidebar-text">Estadistica</span>
                    </a>
                </li>
                <li class="nav-item mb-0 border-bottom">
                    <a class="nav-link text-dark d-flex align-items-center" href="#" title="About">
                        <i class="bi bi-info-circle me-2"></i>
                        <span class="sidebar-text">About</span>
                    </a>
                </li>
            </ul>
        </nav>

        <!-- Contenido principal -->
        <main class="content w-100 h-auto fondo-global ">
            <div class="fondo-logo">
                <img src="/img/logoSena.png" alt="Logo" />
            </div>
            <div style="position: relative;">
                @yield('content')
            </div>
        </main>
    </div>

    <!-- Incluir el script para el topbar desde public/js/topbar.js -->
    <script src="{{ asset('js/topbar.js') }}"></script>
    <script>
        const toggleBtn = document.getElementById('toggleSidebar');
        const sidebar = document.getElementById('sidebar');
        const main = document.getElementById('mainContent');

        toggleBtn.addEventListener('click', () => {
            sidebar.classList.toggle('collapsed');
            main.classList.toggle('expanded');
        });
    </script>
</body>


</html>