<?php

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Model;
use App\Models\Atencion\Atencion; // 👈 IMPORTANTE

class Paciente extends Model
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'sep_participante';
    protected $primaryKey = 'id';
    public $timestamps = false;

    public function atenciones()
    {
        return $this->hasMany(Atencion::class, 'paciente_id');
    }
}
