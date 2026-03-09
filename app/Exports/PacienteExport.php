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


    public function collection()
    {
        return Atencion::with(['paciente.acudiente', 'usuario'])->get();
    }
    public function map($atencion): array
    {
        return [
            $atencion->paciente->acudiente->par_acu_nombre ?? 'N/A',
            $atencion->paciente->acudiente->par_acu_tel ?? 'N/A',
            $atencion->paciente->acudiente->par_acu_parentesco ?? 'N/A',
            $atencion->paciente->par_identificacion,
            $atencion->paciente->par_nombres,
            $atencion->paciente->par_apellidos,
            $atencion->paciente->par_telefono,
            $atencion->fecha_hora,
            $atencion->usuario ? $atencion->usuario->name : 'N/A',
        ];
    }

    public function headings(): array
    {
        return [
            'Nombres Acudiente',
            'Teléfono Acudiente',
            'Parentesco Acudiente',
            'Identificación Paciente',
            'Nombres Paciente',
            'Apellidos Paciente',
            'Teléfono Paciente',
            'Fecha y Hora Atención',
            'Usuario Responsable',
        ];
    }
}
