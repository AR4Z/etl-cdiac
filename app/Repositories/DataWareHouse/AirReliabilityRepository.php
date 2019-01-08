<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\AppGeneralRepositoryBaseTrait;
use Illuminate\Container\Container;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\DataWareHouse\AirReliability;

class AirReliabilityRepository extends EloquentRepository implements ReliabilityRepositoryContract
{
    use AppGeneralRepositoryBaseTrait;

    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(AirReliability::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @param $station_sk
     * @param $date_sk
     * @return mixed
     */
    public function getFirstFromStationAndDate($station_sk, $date_sk) :AirReliability
    {
        return $this->where('station_sk',$station_sk)
            ->where('date_sk' , $date_sk)
            ->first();
    }
}