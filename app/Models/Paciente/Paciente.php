<?php


namespace App\Models;

namespace App\Models\Paciente;

use Illuminate\Database\Eloquent\Model;

class Paciente extends Model
{
    protected $connection = 'senacdti_seguimientopro'; // Conexión a la base externa
    protected $table = 'sep_participante'; // Tabla de pacientes
    protected $primaryKey = 'id'; // Ajusta al nombre del PK si es diferente
    public $timestamps = false; // si la tabla no tiene created_at/updated_at

    // Puedes definir un scope o método para traer solo los campos que necesites
}
