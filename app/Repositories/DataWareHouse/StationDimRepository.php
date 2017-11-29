<?php

namespace App\Repositories\DataWareHouse;


use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\StationDim;

class StationDimRepository extends EloquentRepository
{
    protected $repositoryId = 'rinvex.repository.uniqueid';

    protected $model = StationDim::class;


    public function getDifferentNetName()
    {
        return $this->select('net_name as id','net_name as name')->distinct('net_name')->pluck('id','name');
    }

    public function getStationsForNet($netName)
    {
        return $this->select('station_sk as id','name')->where('net_name','=',$netName)->orderby('name','ASC')->get();
    }

    public function getIdAndNameStations()
    {
        return $this->select('station_sk as id','name')->orderby('name','ASC')->get();
    }

}