<?php

namespace App\Models\Ficha;

use Illuminate\Database\Eloquent\Model;
use App\Models\Paciente\Paciente; // 👈 IMPORTANTE

class Ficha extends Model
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'sep_ficha';
    protected $primaryKey = 'fic_numero';
    public $timestamps = false;


    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'par_identificacion', 'par_identificacion');
    }
}
