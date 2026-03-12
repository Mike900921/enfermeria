<?php

namespace App\Models\Programa;

use App\Models\Ficha\FichaPro;


use Illuminate\Database\Eloquent\Model;

class Programa extends Model
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'sep_programa';
    protected $primaryKey = 'prog_codigo';
    public $timestamps = false;

    public function fichapro()
    {
        return $this->belongsTo(FichaPro::class, 'prog_codigo', 'prog_codigo');
    }
}
