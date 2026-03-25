<?php

namespace App\Models\Eps;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente\Paciente;
use App\Models\Eps\resultados_apr;

class caracterizacion_apr extends Model
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'sep_caracterizacion_apr';
    protected $primaryKey = 'par_identificacion';
    public $timestamps = false;

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'par_identificacion', 'par_identificacion');
    }

    public function resultados_apr()
    {
        return $this->hasMany(resultados_apr::class, 'caracterizacion_id', 'id')
            ->where('pregunta_id', 7);
    }
}
