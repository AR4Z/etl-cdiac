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
        $model = $this->newEmptyEntity();

        return DB::connection($model->getConnection()->getConfig()['name'])->table($model->getTable());
    }

    /**
     * @param array $columns
     * @return mixed
     */
    public function fillingColumnsModel(array $columns = [])
    {
        return $this->createModel()->fill($columns);
    }

    /**
     * @return mixed
     */
    public function newEmptyEntity()
    {
        return $this->createModel();
    }
}