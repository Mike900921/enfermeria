<?php

namespace App\Models\Atencion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\Users\User;
use App\Models\Paciente\Paciente;
use App\Models\Paciente\AcudientePaciente;
use App\Models\Motivo\Motivo;
use App\Models\Ficha\Ficha;


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
        'motivo_id',
        'procedimientos',
        'observaciones',
    ];


    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id')->withTrashed();
    }
  
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'par_identificacion');
    }

    public function ficha()
    {
        // fic_numero es la llave primaria en la tabla de fichas
        return $this->belongsTo(Ficha::class, 'ficha_id', 'fic_numero');
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
    public function motivo()
    {
        return $this->belongsToMany(Motivo::class, 'atencion_motivo', 'atencion_id', 'motivo_id')->withTimestamps();
    }
}
