<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>imprimir</title>
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 12px;
            color: #333;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            color: #198754;
        }

        .section {
            border: 1px solid #ccc;
            width: 100%;
            padding: 10px;
            margin-bottom: 15px;
            /* Importante para que el borde no se corte */
            box-sizing: border-box;
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
            vertical-align: top;
        }


        .box {
            padding: 5px 0;
        }


        .firma {
            margin-top: 60px;
            border-top: 1px solid #000;
            width: 250px;
            margin-left: auto;
            margin-right: auto;
            text-align: center;
            padding-top: 5px;
        }

        .label {
            font-weight: bold;
        }
    </style>
</head>

<body>

    <table style="width: 100%; border-bottom: 2px solid #39A900; padding-bottom: 10px; margin-bottom: 20px;">
        <tr>
            <td style="width: 20%; text-align: left; vertical-align: middle;">
                <img src="{{ public_path('img/logoSena.png') }}" width="70">
            </td>
            <td style="width: 60%; text-align: center; vertical-align: middle;">
                <h2 class="title">Registro de Atención</h2>
            </td>
            <td style="width: 20%; text-align: right; vertical-align: middle; font-size: 12px;">
                <strong>Fecha De Impresión:</strong><br>
                {{ date('d/m/Y') }}
            </td>
        </tr>
    </table>

    <div class="section">
        <h4>Datos del Aprendiz</h4>
        <div class="row">
            <div class="col">
                <span class="label">Nombre Completo:</span>
                {{ $atencion->paciente->par_nombres }} {{ $atencion->paciente->par_apellidos }}
            </div>
            <div class="col">
                <span class="label">N.Identificación:</span>
                {{ $atencion->paciente->par_identificacion ?? 'No registrado' }}
            </div>
            <div class="col">
                <span class="label">Edad:</span>
                {{ $atencion->paciente->par_fec_nacimiento ? \Carbon\Carbon::parse($atencion->paciente->par_fec_nacimiento)->age : 'No registrado' }}
            </div>
            <div class="col">
                <span class="label">tipo de documento:</span>
                {{ $tiposDocumentoPorId[(string) ($atencion->paciente->par_tipo_doc ?? '')] ?? ($atencion->paciente->par_tipo_doc ?? 'No registrado') }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Teléfono:</span>
                {{ $atencion->paciente->par_telefono ?? 'No registrado' }}
            </div>
            <div class="col">
                <span class="label">Correo:</span>
                {{ $atencion->paciente->par_correo ?? 'No registrado' }}
            </div>
        </div>
        <div class="row">
            <div class="col">
                <span class="label">Programa:</span>
                {{ $atencion->ficha->fichapro->programa->prog_nombre ?? 'No registrado' }}
            </div>
            <div class="col">
                <span class="label">Ficha:</span>
                {{ $atencion->ficha->fic_numero ?? 'No registrado' }}
            </div>
        </div>



    </div>
    <div class="section">
        <h4>Información Clínica</h4>
        <div class="row">
            <div class="box">
                <span class="label">Motivo de consulta:</span><br>
                {{ $atencion->motivo->pluck('motivo')->join(', ') ?: 'No registrado' }}
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
            <div class="col">
                <span class="label">Fecha de Atención:</span>
                {{ \Carbon\Carbon::parse($atencion->fecha_hora)->format('d/m/Y') }}
            </div>
            <div class="col">
                <span class="label">Hora:</span>
                {{ \Carbon\Carbon::parse($atencion->fecha_hora)->format('h:i A') }}
            </div>
        </div>

    </div>
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
            <div class="col">
                <span class="label">Parentesco:</span>
                {{ $atencion->paciente->acudiente->par_acu_parentesco ?? 'No registrado' }}
            </div>
        </div>

    </div>
    <div style="margin-top: 40px; text-align: center;">
        <div class="firma">
            Firma Profesional
        </div>
    </div>
</body>

</html>
