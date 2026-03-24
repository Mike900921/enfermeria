<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>imprimir</title>
</head>

<body>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #198754;
            margin-bottom: 20px;
            padding-bottom: 10px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #198754;
        }

        .section {
            border: 1px solid #ccc;
            padding: 10px;
            margin-bottom: 15px;
        }

        .section h4 {
            margin: 0 0 10px 0;
            color: #198754;
        }

        .row {
            width: 100%;
            margin-bottom: 5px;
        }

        .col {
            display: inline-block;
            width: 48%;
        }

        .full {
            width: 100%;
        }

        .box {
            padding: 8px;
            min-height: 40px;


        }

        .footer {
            margin-top: 40px;
            text-align: center;
        }

        .firma {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 250px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
        }

        .label {
            font-weight: bold;
        }
    </style>

    <!-- ENCABEZADO -->

    <table style="width: 100%; border-bottom: 2px solid #39A900; padding-bottom: 10px; margin-bottom: 20px;">

        <tr>
            <td style="width: 20%; text-align: left; vertical-align: middle;">
                <img src="{{ public_path('img/logoSena.png') }}" width="70">
            </td>
            <td style="width: 60%; text-align: center; vertical-align: middle;">
                <h2 class="title">
                    Registro de Atención
                </h2>
            </td>

            <td style="width: 20%; text-align: right; vertical-align: middle; font-size: 12px;">
                <strong> Fecha De Impresión:</strong><br>
                {{ date('d/m/Y') }}
            </td>
        </tr>
    </table>


    <!-- DATOS PACIENTE -->
    <div class="section">
        <h4>Datos del Paciente</h4>

        <div class="row">
            <div class="col">
                <span class="label">Nombre:</span>
                {{ $atencion->paciente->par_nombres }} {{ $atencion->paciente->par_apellidos }}
            </div>

            <div class="col">
                <span class="label">Teléfono:</span>
                {{ $atencion->paciente->par_telefono ?? 'No registrado' }}
            </div>
        </div>


        <div class="row">
            <div class="col">
                <span class="label">Ficha:</span>
                {{ $atencion->paciente->ficha->fic_numero ?? 'No registrado' }}


            <!-- INFORMACION CLINICA -->
            <div class="section">
                <h4>Información Clínica</h4>

                <div class="row">
                    <div class="box">
                        <span class="label">Motivo de consulta:</span><br>
                        {{ $atencion->motivo ?? 'No registrado' }}
                    </div>
                </div>

                <div class="row">
                    <div class="box">
                        <span class="label">Procedimientos:</span><br>
                        {{ $atencion->procedimientos ?? 'No registrado' }}
                    </div>
                </div>

                <div class="row">
                    <div class="box">
                        <span class="label">Observaciones:</span><br>
                        {{ $atencion->observaciones ?? 'No registrado' }}
                    </div>
                </div>

                <div class="row">
                    <div class="box">
                        <span class="label">Fecha de Atención:</span>
                        {{ \Carbon\Carbon::parse($atencion->fecha_hora)->format('d/m/Y') }}
                    </div>
                    <div class="box">
                        <span class="label">Hora:</span>
                        {{ \Carbon\Carbon::parse($atencion->fecha_hora)->format('h:i A') }}
                    </div>
                </div>

            </div>


            <!-- ACUDIENTE -->
            <div class="section">
                <h4>Datos del Acudiente</h4>

                <div class="row">
                    <div class="col">
                        <span class="label">Nombre:</span>
                        {{ $atencion->paciente->acudiente->par_acu_nombre ?? 'No registrado' }}
                    </div>

                    <div class="col">
                        <span class="label">Teléfono:</span>
                        {{ $atencion->paciente->acudiente->par_acu_tel ?? 'No registrado' }}
                    </div>
                </div>

                <div class="row">
                    <div class="full">
                        <span class="label">Parentesco:</span>
                        {{ $atencion->paciente->acudiente->par_acu_parentesco ?? 'No registrado' }}
                    </div>
                </div>

            </div>


            <!-- FIRMA -->
            <div class="footer">

                <div class="firma">
                    Firma Profesional
                </div>

            </div>
</body>

</html>
