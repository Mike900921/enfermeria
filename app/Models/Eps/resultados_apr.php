<?php

namespace App\Models\Eps;

use Illuminate\Database\Eloquent\Model;
use App\Models\Eps\caracterizacion_apr;

class resultados_apr extends Model
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'sep_caracterizacion_resultados_apr';
    protected $primaryKey = 'par_identificacion';
    public $timestamps = false;


    public function caracterizacion_apr()
    {
        return $this->hasMany(caracterizacion_apr::class, 'id', 'caracterizacion_id');
    }
}
