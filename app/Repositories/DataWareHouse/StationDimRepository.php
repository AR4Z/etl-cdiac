<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\DataWareHouse\StationDim;

class StationDimRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(StationDim::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @return mixed
     */
    public function getDifferentNetName()
    {
        return $this->select('net_name as id','net_name as name')->distinct('net_name')->pluck('id','name');
    }

    /**
     * @param $netName
     * @return mixed
     */
    public function getStationsForNet($netName)
    {
        return $this->select('station_sk as id','name')->where('net_name','=',$netName)->orderby('name','ASC')->get();
    }

    /**
     * @return mixed
     */
    public function getIdAndNameStations()
    {
        return $this->select('station_sk as id','name')->orderby('name','ASC')->get();
    }

    /**
     * @param $netName
     * @return mixed
     */
    public function getIdStationForName($netName)
    {
        return $this->select('station_sk as id')->where('net_name',$netName)->first();
    }
}