<?php

namespace App\Repositories;

use DB;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Exceptions\RepositoryException;
use Rinvex\Repository\Repositories\EloquentRepository;

class AppBaseRepository extends EloquentRepository
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
        try {
            return $this->createModel()->fill($columns);
        } catch (RepositoryException $e) { /** TODO  */ dd('Fallo el filtrado de array');}
    }

    /**
     * @return mixed
     */
    public function newEmptyEntity()
    {
        try {
            return $this->createModel();
        } catch (RepositoryException $e) { /** TODO */ dd('Fallo la creacion del modelo');}
    }
}