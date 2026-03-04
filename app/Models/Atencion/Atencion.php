<?php

namespace App\Models\Atencion;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User; // 👈 IMPORTANTE
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

    public function usuario()
    {
        return $this->belongsTo(User::class, 'usuario_id');
    }

    public function paciente()
    {
        return $this->belongsTo(Paciente::class, 'paciente_id', 'id');
    }
}