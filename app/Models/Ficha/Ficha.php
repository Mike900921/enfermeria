<?php

namespace App\Models\Ficha;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente\Paciente; // 👈 IMPORTANTE
use App\Models\Ficha\FichaPro;

class Ficha extends Model
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'sep_matricula';
    protected $primaryKey = 'mat_id';
    public $timestamps = false;


    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'par_identificacion', 'par_identificacion');
    }

    public function fichapro()
    {
        return $this->hasOne(FichaPro::class, 'fic_numero', 'fic_numero');
    }
}
