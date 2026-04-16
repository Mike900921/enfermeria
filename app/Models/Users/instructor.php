<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class instructor extends Authenticatable
{
    protected $connection = 'senacdti_seguimientopro';
    protected $table = 'users';
    protected $primaryKey = 'par_identificacion';
    public $timestamps = false;

    public function participante()
    {
        return $this->hasOne(
            \App\Models\Paciente\Paciente::class,
            'par_identificacion',
            'par_identificacion'
        );
    }


    public function getFullNameAttribute()
    {
        return $this->participante
            ? trim($this->participante->par_nombres . ' ' . $this->participante->par_apellidos)
            : 'Instructor';
    }

    public function getRolIdAttribute()
    {
        return optional($this->participante)->rol_id;
    }
}
