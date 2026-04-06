@extends('layouts.base')

@section('titulo', 'Consulta de Aprendiz')

@section('content')

    <div class="container mt-4">
        <div class="card shadow">
            <div class="card-header">
                <h4>Encuesta de Caracterizacion</h4>
            </div>

            <div class="card-body align-items-center d-flex flex-column">
                <p>Haz clic en el botón para ingresar a SETALPRO o escanea el codigo qr para diligenciar la encuesta de
                    caracterización.</p>

                <a href="https://setalpro.senacdti.com" class=" btn btn-verde" target="_blank">
                    <i class="bi bi-search"></i> Ir a setalpro
                </a>
                <img class="col-12" style="max-width:500px" src="{{ asset('img/marco_qr.png') }}" alt="Marco QR">
            </div>


            {{-- Qr para acceder a SETALPRO con imagen marco_qr de fondo --}}

            {{-- <div class="card-body text-center " style="margin-top: 80px; position: relative;">
            </div> --}}


        </div>
        {{-- <div class="card-body text-center " style="margin-top: 80px;">

            {!! QrCode::size(200)->generate('https://setalpro.senacdti.com/login') !!}

        </div> --}}
    </div>

@endsection
