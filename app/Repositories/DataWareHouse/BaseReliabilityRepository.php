<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\BaseFactStructureRepository;

class BaseReliabilityRepository extends BaseFactStructureRepository
{
    /**
     * @param $station_sk
     * @param $date_sk
     * @return array
     */
    public function firstStationAndDate($station_sk, $date_sk) : array
    {
        return (array)$this->queryBuilder()->select('*')
            ->where('station_sk',$station_sk)
            ->where('date_sk',$date_sk)
            ->first();
    }
}