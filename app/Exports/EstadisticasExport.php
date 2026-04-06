<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class EstadisticasExport implements FromCollection, WithHeadings
{
    protected $data;
    protected $ver;

    public function __construct($data, $ver)
    {
        $this->data = $data;
        $this->ver = $ver;
    }

    public function collection()
    {
        return $this->data->map(function ($item) {
            if ($this->ver === 'programa') {
                return [
                    'Programa' => $item->etiqueta,
                    'Coordinador' => ($item->nombre_coord ?? 'N/A') . ' ' . ($item->apellido_coord ?? ''),
                    'Total Atenciones' => $item->total,
                ];
            } elseif ($this->ver === 'pacientes') {
                return [
                    'Paciente' => $item->etiqueta,
                    'Número Documento' => $item->numeroDocumento ?? 'N/A',
                    'Ficha' => $item->fichaPaciente ?? 'N/A',
                    'Total Atenciones' => $item->total,
                ];
            } elseif ($this->ver === 'motivos') {
                return [
                    'Motivo' => $item->etiqueta,
                    'Total Atenciones' => $item->total,
                ];
            } else { // ficha
                return [
                    'Ficha' => $item->etiqueta,
                    'Programa' => $item->programa ?? 'N/A',
                    'Total Atenciones' => $item->total,
                ];
            }
        });
    }

    public function headings(): array
    {
        if ($this->ver === 'programa') {
            return ['Programa', 'Coordinador', 'Total Atenciones'];
        } elseif ($this->ver === 'pacientes') {
            return ['Paciente', 'Número Documento', 'Ficha', 'Total Atenciones'];
        } elseif ($this->ver === 'motivos') {
            return ['Motivo', 'Total Atenciones'];
        } else { // ficha
            return ['Ficha', 'Programa', 'Total Atenciones'];
        }
    }
}