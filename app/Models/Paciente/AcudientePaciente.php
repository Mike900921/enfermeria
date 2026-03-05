<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Model;

class AcudientePaciente extends Model
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'sep_acudiente_participante';
    protected $primaryKey = 'id';
    public $timestamps = false;
}
