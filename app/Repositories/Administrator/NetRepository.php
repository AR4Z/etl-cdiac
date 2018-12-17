<?php

namespace App\Repositories\Administrator;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Database\Query\Builder;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\Net;
use DB;

class NetRepository extends EloquentRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Net::class)->setRepositoryId('rinvex.repository.uniqueid');
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
     * @return Collection
     */
    public function getNetName() : Collection
    {
        return $this->select('id','name')->where('etl_active',true)->pluck('name','id');
    }

    //Auditory System Functions

    /**
     * @param int $station_id
     * @return Array
     */
    public function getNetById($station_id){
        return $this->select('id', 'name')
            ->where('etl_active',true)
            ->where('id','=',$station_id)
            ->orderby('name','ASC')
            ->get()->toArray();
    }

    /**
     * @return object
     */
    public function getNet(){
        return $this
            ->select('id', 'name')
            ->where('etl_active',true)
            ->orderby('name','ASC')
            ->get();



    }


}