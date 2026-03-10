<?php

namespace App\Models\Atencion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;
use App\Models\Paciente\Paciente;
use App\Models\Paciente\AcudientePaciente;

class Atencion extends Model
{
    use HasFactory;

    protected $connection = 'enfermeria'; // 👈 importante
    protected $table = 'atenciones';

    protected $fillable = [
        'paciente_id',
        'user_id',
        'ficha_id',
        'fecha_hora',
        'motivo',
        'ficha_id',
        'procedimientos',
        'observaciones',
    ];



    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'par_identificacion');
    }

    public function acudiente() // Relación hasOneThrough para obtener el acudiente a través del paciente. importante: el paciente_id en Atencion debe coincidir con par_identificacion en Paciente, y luego se une con AcudientePaciente usando par_identificacion_apr.
    {
        return $this->hasOneThrough(
            AcudientePaciente::class,
            Paciente::class,
            'par_identificacion',     // Clave de Paciente que coincide con paciente_id de Atencion
            'par_identificacion_apr', // Clave de AcudientePaciente que coincide con par_identificacion de Paciente
            'paciente_id',            // Local key en Atencion
            'par_identificacion'      // Local key en Paciente
        );
    }
}
