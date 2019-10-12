<?php

namespace App\Entities\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'public';

    protected $table = 'user';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'remember_token',
    ];

    public function role_applications()
    {
        return $this->hasMany(RoleApplication::class);
    }
}
