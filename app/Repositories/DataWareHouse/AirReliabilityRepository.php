<?php

namespace App\Repositories\DataWareHouse;

use Illuminate\Container\Container;
use App\Entities\DataWareHouse\AirReliability;

class AirReliabilityRepository extends BaseReliabilityRepository implements ReliabilityRepositoryContract
{
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
        return $this->where('station_sk',$station_sk)->where('date_sk' , $date_sk)->first();
    }

    /**
     * @param int $stationSk
     * @param int $dateSk
     * @param array $arr
     * @return int|mixed
     */
    public function updateTrustAndSupport(int $stationSk, int $dateSk, array $arr = [])
    {
        return $this->queryBuilder()->where('station_sk',$stationSk)->where('date_sk',$dateSk)->update($arr);
    }
}