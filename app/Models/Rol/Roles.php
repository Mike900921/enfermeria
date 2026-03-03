<?php

namespace App\Models\Rol;

use Illuminate\Database\Eloquent\Model;
use App\Models\Users\User;

class Roles extends Model
{
    public function users()
    {
        return $this->hasMany(User::class, 'roles_id');
    }
}
