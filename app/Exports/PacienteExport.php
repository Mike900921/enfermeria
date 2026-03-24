<?php

namespace App\Exports;

use App\Models\Atencion\Atencion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PacienteExport implements FromCollection, WithMapping, WithHeadings
{
    protected $atenciones;

    public function __construct($atenciones)
    {
        $this->atenciones = $atenciones;
    }

    public function collection()
    {
        return $this->atenciones;
    }

    public function map($atencion): array
    {
        // Usar `optional` para los datos relacionados
        $paciente = $atencion->paciente;
        $acudiente = optional($atencion->acudiente);
        $usuario = optional($atencion->usuario);

        // Concatenar nombre y apellido del usuario
        $nombreCompletoUsuario = trim(
            ($usuario->name ?? '') . ' ' . ($usuario->last_name ?? '')
        ) ?: 'No registrado';

        return [
            optional($paciente)->par_identificacion ?? 'No registrado',
            optional($paciente)->par_nombres ?? 'No registrado',
            optional($paciente)->par_apellidos ?? 'No registrado',
            optional($paciente)->par_telefono ?? 'No registrado',
            $atencion->fecha_hora,
            $atencion->motivo->pluck('motivo')->join(', '),
            $atencion->procedimientos,
            $atencion->observaciones,
            $nombreCompletoUsuario,
            $acudiente->par_acu_nombre ?? 'No registrado',
            $acudiente->par_acu_tel ?? 'No registrado',
            $acudiente->par_acu_parentesco ?? 'No registrado',
        ];
    }

    public function headings(): array
    {
        return [
            'Identificación Paciente',
            'Nombres Paciente',
            'Apellidos Paciente',
            'Teléfono Paciente',
            'Fecha y Hora Atención',
            'Motivo',
            'Procedimientos',
            'Observaciones',
            'Usuario Responsable',
            'Nombre Acudiente',
            'Teléfono Acudiente',
            'Parentesco Acudiente',
        ];
    }
}
