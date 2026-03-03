<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="{{ asset('css/topbar.css') }}">
    <title>Document</title>
</head>

<body>

    <header class="topbar">
        <div class="menu">
            <button onclick="toggleMenu()">☰</button>
            <h3>Consultas enfermería</h3>
        </div>

    </header>

    <div class="layout">
        <aside id="sidebar" class="sidebar">
            <ul>
                <li><a href="{{ route('users.index') }}" title="Usuarios">Usuarios</a></li>
                <li>Atenciones</li>
                <li>Encuesta</li>
                <li>About</li>
            </ul>
        </aside>
        @yield('content')
    </div>

    <script src="{{ asset('js/topbar.js') }}"></script>
</body>

</html>
