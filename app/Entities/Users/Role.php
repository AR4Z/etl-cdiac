<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $connection = 'public';
    protected $table = 'role';
    protected $primaryKey = 'id';

    public function role_applications()
    {
        return $this->hasMany(RoleApplication::class);
    }
}
