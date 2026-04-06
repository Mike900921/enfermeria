@extends('layouts.base')

@section('content')
    <style>
        .buscador {
            display: flex;
            justify-content: center;
            align-items: center;
        }
    </style>

    {{-- Alertas de éxito --}}
            @if (session('success'))
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
                    <div class="alert alert-success alert-dismissible fade show shadow-lg border-0" role="alert"
                        style="border-radius: 20px; padding-right: 50px;">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                </div>
            @endif

            {{-- Alertas de error --}}
            @if ($errors->any())
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
                    @foreach ($errors->all() as $error)
                        <div class="alert alert-danger alert-dismissible fade show shadow-lg border-0" role="alert"
                            style="border-radius: 20px; padding-right: 50px;">
                            <i class="fas fa-exclamation-circle me-2"></i> {{ $error }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>
                    @endforeach
                </div>
            @endif

    <div class="container">
        <div class="row">
            <div class="col-12">

                <div class="row buscador">
                    <div class="col-3 text-center buscador mt-5">
                        <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
                            <i class="bi bi-plus-lg me-1"></i> Crear motivo
                        </button>
                        <x-modal-motivos.crear-motivo />
                    </div>

                    <div class="col-5">
                        <h1 class="text-center mt-4 fw-bold">Lista Motivos</h1>
                    </div>

                    <div class="col-4 pt-5">
                        <input type="text" id="buscarMotivo" class="form-control" placeholder="Buscar motivo...">
                    </div>
                </div>

                {{-- CONTENEDOR RESULTADOS --}}
                <div id="resultados" class="mt-4 d-flex justify-content-center">
                    @include('motivos.partials.tablaMotivos', ['motivos' => $motivos])
                </div>

            </div>
        </div>
    </div>

    {{-- LOADER --}}
    <div id="loader" style="display:none; text-align:center;">
        <div class="spinner-border text-primary"></div>
    </div>

    <script>
        let timeout = null;

        // 🔍 BUSCADOR
        document.getElementById('buscarMotivo').addEventListener('keyup', function() {
            clearTimeout(timeout);

            let query = this.value;

            timeout = setTimeout(() => {

                let url = query ? `/buscarMotivos?q=${query}` : `/motivos`;

                document.getElementById('loader').style.display = 'block';

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById('resultados').innerHTML = data;
                        document.getElementById('loader').style.display = 'none';
                    });

            }, 300);
        });


        // 📄 PAGINACIÓN AJAX
        document.addEventListener('click', function(e) {
            if (e.target.closest('.pagination a')) {
                e.preventDefault();

                let url = e.target.closest('a').getAttribute('href');

                document.getElementById('loader').style.display = 'block';

                fetch(url, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest'
                        }
                    })
                    .then(res => res.text())
                    .then(data => {
                        document.getElementById('resultados').innerHTML = data;
                        document.getElementById('loader').style.display = 'none';
                    });
            }
        });
    </script>
@endsection
