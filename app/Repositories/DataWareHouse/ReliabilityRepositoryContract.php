<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\RepositoriesContract;

interface ReliabilityRepositoryContract extends RepositoriesContract
{
    /**
     * @param $station_sk
     * @param $date_sk
     * @return mixed
     */
    public function getFirstFromStationAndDate($station_sk, $date_sk);

    /**
     * @param int $stationSk
     * @param int $dateSk
     * @param array $arr
     * @return mixed
     */
    public function updateTrustAndSupport(int $stationSk, int $dateSk, array $arr = []);
}