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
        $paciente = optional($atencion->paciente);
        $acudiente = optional($atencion->acudiente);
        $usuario = optional($atencion->usuario);

        // Datos de ficha y programa con optional para evitar errores
        $ficha = optional($atencion->ficha);
        $fichapro = optional($ficha->fichapro);
        $programa = optional($fichapro->programa);

        // Concatenar nombre y apellido del usuario
        $nombreCompletoUsuario = trim(
            ($usuario->name ?? '') . ' ' . ($usuario->last_name ?? '')
        ) ?: 'No registrado';

        return [
            $paciente->par_identificacion ?? 'No registrado',
            $paciente->par_nombres ?? 'No registrado',
            $paciente->par_apellidos ?? 'No registrado',
            $paciente->par_telefono ?? 'No registrado',
            $programa->prog_nombre ?? 'No registrado',
            $ficha->fic_numero ?? 'No registrado',

            $atencion->fecha_hora,

            optional($atencion->motivo)->pluck('motivo')->join(', ') ?? 'No registrado',
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
            'Identificación_Aprendiz',
            'Nombres_Aprendiz',
            'Apellidos_Aprendiz',
            'Teléfono_Aprendiz',
            'Programa_Aprendiz',
            'Ficha_Aprendiz',
            'Fecha_Hora_Atención',
            'Motivo',
            'Procedimientos',
            'Observaciones',
            'Usuario_Responsable',
            'Nombre_Acudiente',
            'Teléfono_Acudiente',
            'Parentesco_Acudiente',
        ];
    }
}
