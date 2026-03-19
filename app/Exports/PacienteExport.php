<?php

namespace App\Exports;

use App\Models\Atencion\Atencion;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class PacienteExport implements FromCollection, WithMapping, WithHeadings
{
    /**
     * @return \Illuminate\Support\Collection
     */
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
        $acudiente = optional($atencion->acudiente);

        return [
            $atencion->paciente->par_identificacion ?? 'N/A',
            $atencion->paciente->par_nombres ?? 'N/A',
            $atencion->paciente->par_apellidos ?? 'N/A',
            $atencion->paciente->par_telefono ?? 'N/A',
            $atencion->fecha_hora,
            $atencion->motivo->motivo,
            $atencion->procedimientos,
            $atencion->observaciones,
            $atencion->usuario ? $atencion->usuario->name : 'N/A',
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
