<?php

namespace App\Models\Ficha;

use App\Models\Programa\Programa;
use App\Models\Ficha\Ficha;

use Illuminate\Database\Eloquent\Model;

class FichaPro extends Model
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'sep_ficha';
    protected $primaryKey = 'fic_numero';
    public $timestamps = false;

    public function programa()
    {
        return $this->hasOne(Programa::class, 'prog_codigo', 'prog_codigo');
    }

    public function ficha()
    {
        return $this->hasOne(Ficha::class, 'fic_numero', 'fic_numero');
    }
}
