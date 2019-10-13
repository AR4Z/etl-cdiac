<?php

namespace App\Repositories\Users;

use App\Entities\Users\RoleApplication;
use Rinvex\Repository\Repositories\EloquentRepository;

use DB;

/**
 *
 */
class RoleApplicationRepository extends EloquentRepository
{

    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = RoleApplication::class;

    protected function queryBuilder()
    {
        return DB::connection('public')->table('role_application');
    }

    public function getAll()
    {
        return $this->get();
    }

    public function createRoleApp(array $role_app_data)
    {
        $role_app = $this->createModel();
        $role_app->fill($role_app_data);

        return $this->create($role_app->toArray());
    }
}
