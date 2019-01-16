<?php

namespace App\Repositories;

use DB;
use Illuminate\Database\Query\Builder;

trait AppGeneralRepositoryBaseTrait
{
    /**
     * @return Builder
     */
    public function queryBuilder(): Builder
    {
        $model = $this->createModel();

        return DB::connection($model->getConnection()->getConfig()['name'])->table($model->getTable());
    }
}