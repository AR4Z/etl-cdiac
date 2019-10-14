<?php

namespace App\Entities\Users;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    /**
     * The database connection used by the model.
     *
     * @var string
     */
    protected $connection = 'public';

    protected $table = 'user';
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'lastname', 'email', 'password', 'institution', 'identification_document', 'confirmed_code'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */

    protected $hidden = [
        'remember_token',
    ];

    public function roleApplications()
    {
        return $this->hasMany(RoleApplication::class);
    }

    public function isAdministrator()
    {
        return $this->roleApplications()->where('role_id', 1)->whereNull('until')->exists();
    }
}
