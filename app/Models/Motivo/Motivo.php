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
        return $this->hasMany(Atencion::class);
    }
}
