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
    <title>Document</title>

</head>
<style>
    .nav-link.text-dark:hover {
        background-color: #cccccc;
        border-radius: 5px;
    }
</style>

<body>

    <header class="topbar">
        <div class="menu">
            <button onclick="toggleMenu()">☰</button>
            <h3>Consultas enfermería</h3>
        </div>
    </header>

    <div class="layout">
        <aside id="sidebar" class="sidebar">
            <ul class="nav flex-column">
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('users.index') }}"
                        title="Usuarios">
                        <i class="bi bi-people-fill me-2"></i>
                        <span class="sidebar-text">Usuarios</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('consulta.index') }}"
                        title="Aprendices">
                        <i class="bi bi-person-check-fill me-2"></i>
                        <span class="sidebar-text">Aprendices</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('registros.index') }}"
                        title="Atenciones">
                        <i class="bi bi-journal-text me-2"></i>
                        <span class="sidebar-text">Atenciones</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark d-flex align-items-center" href="#" title="Encuesta">
                        <i class="bi bi-card-checklist me-2"></i>
                        <span class="sidebar-text">Encuesta</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark d-flex align-items-center" href="{{ route('estadisticas.index') }}"
                        title="Estadistica">
                        <i class="bi bi-bar-chart  me-2"></i>
                        <span class="sidebar-text">Estadistica</span>
                    </a>
                </li>
                <li class="nav-item mb-2">
                    <a class="nav-link text-dark d-flex align-items-center" href="#" title="About">
                        <i class="bi bi-info-circle me-2"></i>
                        <span class="sidebar-text">About</span>
                    </a>
                </li>
            </ul>

            <!-- LOGOUT -->
            <form method="POST" action="{{ route('logout') }}" class="">
                @csrf
                <button type="submit" class="nav-link text-dark d-flex align-items-center logout-btn" title="logout">
                    <i class="bi bi-door-closed me-2 m-lg-1"></i>
                    <span class="sidebar-text">logout</span>
                </button>
            </form>
        </aside>
        @yield('content')
    </div>
    <script src="{{ asset('js/topbar.js') }}"></script>
</body>


</html>
