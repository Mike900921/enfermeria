<?php


namespace App\Models\Motivo;

use Illuminate\Database\Eloquent\Model;
use App\Models\Atencion\Atencion;

class Motivo extends Model
{
    protected $fillable = ['nombre'];


    public function atenciones()
    {
        return $this->hasMany(Atencion::class);
    }
}
