<?php

namespace App\Repositories\TemporaryWork;

use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\TemporaryWork\ExistFactGroundwater;
use DB;

class ExistFactGroundwaterRepository extends EloquentRepository implements ExistRepositoryContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(ExistFactGroundwater::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return Builder
     * @throws \Rinvex\Repository\Exceptions\RepositoryException
     */
    public function queryBuilder(): Builder
    {
        $model = $this->createModel();

        return DB::connection($model->getConnection()->getConfig()['name'])->table($model->getTable());
    }
}