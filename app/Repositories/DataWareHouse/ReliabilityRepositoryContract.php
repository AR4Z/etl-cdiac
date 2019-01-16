<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\RepositoriesContract;

interface ReliabilityRepositoryContract extends RepositoriesContract
{
    public function getFirstFromStationAndDate($station_sk, $date_sk);
}