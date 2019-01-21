<?php

namespace App\Repositories\Administrator;

use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use Illuminate\Support\Collection;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Administrator\Net;
use App\Repositories\AppGeneralRepositoryBaseTrait;

class NetRepository extends EloquentRepository implements RepositoriesContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Net::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return Collection
     */
    public function getNetName() : Collection
    {
        return $this->select('id','name')->where('etl_active',true)->pluck('name','id');
    }


    public function getNetsForServerAcquisition() : array
    {
        return $this->select('id','name')->where('etl_active',true)->pluck('name','id')->toArray();
    }

    //Auditory System Functions

    /**
     * @param int $station_id
     * @return array
     */
    public function getNetById(int $station_id) : array
    {
        return $this->select('id', 'name')->where('etl_active',true)->where('id','=',$station_id)->orderby('name','ASC')->get()->toArray();
    }

    /**
     * @return Collection
     */
    public function getNet() : Collection
    {
        return $this->select('id', 'name')->where('etl_active',true)->orderby('name','ASC')->get();
    }
}