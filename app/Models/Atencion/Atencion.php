<?php

namespace App\Models\Atencion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;
use App\Models\Paciente\Paciente;


class Atencion extends Model
{
    use HasFactory;

    protected $table = 'atenciones';

    protected $fillable = [
        'paciente_id',
        'usuario_id',
        'fecha_hora',
        'motivo',
        'procedimientos',
        'observaciones',
    ];

    // Relación con el usuario de enfermería
    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    // Relación con el paciente (modelo externo)
    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'id');
    }
}
