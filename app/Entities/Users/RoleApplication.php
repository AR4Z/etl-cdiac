<?php

namespace App\Entities\Users;

use Illuminate\Database\Eloquent\Model;

class RoleApplication extends Model
{
    protected $connection = 'public';
    protected $table = 'role_application';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $fillable = [
        'role_id', 'application_id', 'user_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function application()
    {
        return $this->belongsTo(Application::class);
    }
}
