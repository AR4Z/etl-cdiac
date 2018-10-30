<?php

namespace App\Repositories\Administrator;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\Connection;
use DB;

class ConnectionRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Connection::class)->setRepositoryId('rinvex.repository.uniqueid');
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

    /**
     * @param array $variables
     * @return Collection
     */
    public function getStationsNotIn(array $variables) : Collection
    {
        return $this->select('*')->whereNotIn('id',$variables)->get();
    }

    /**
     * @return Collection
     */
    public function searchEtlActive() : Collection
    {
        return $this->select('*')->where('etl_active',true)->get();
    }
}