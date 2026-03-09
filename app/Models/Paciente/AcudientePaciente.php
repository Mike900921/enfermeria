<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Model;
use App\Models\Atencion\Atencion;

class AcudientePaciente extends Model
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'sep_acudiente_participante';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'par_identificacion_apr', 'par_identificacion');
    }
}
