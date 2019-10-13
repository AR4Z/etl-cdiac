<?php

namespace App\Repositories\Users;

use App\Entities\Users\Application;
use Rinvex\Repository\Repositories\EloquentRepository;

use DB;
/**
 *
 */
class ApplicationRepository extends EloquentRepository
{

    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = Application::class;

    protected function queryBuilder()
    {
        return DB::connection('public')->table('application');
    }

    public function getAll()
    {
        return $this->get();
    }
}