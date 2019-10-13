<?php

namespace App\Repositories\Users;

use App\Entities\Users\Role;
use Rinvex\Repository\Repositories\EloquentRepository;

use DB;
/**
 *
 */
class RoleRepository extends EloquentRepository
{

    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = Role::class;

    protected function queryBuilder()
    {
        return DB::connection('public')->table('role');
    }

    public function getAll()
    {
        return $this->get();
    }
}