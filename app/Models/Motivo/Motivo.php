<?php


namespace App\Models\Motivo;
use Illuminate\Database\Eloquent\SoftDeletes;

use Illuminate\Database\Eloquent\Model;
use App\Models\Atencion\Atencion;

class Motivo extends Model
{
    use SoftDeletes;
    protected $fillable = ['motivo'];


    public function atenciones()
    {
        return $this->belongsToMany(Atencion::class, 'atencion_motivo', 'motivo_id', 'atencion_id')->withTimestamps();
    }
}
