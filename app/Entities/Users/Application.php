<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $connection = 'public';
    protected $table = 'application';
    protected $primaryKey = 'id';

    public function role_applications() {
        return $this->hasMany(RoleApplication::class);
    }
}
