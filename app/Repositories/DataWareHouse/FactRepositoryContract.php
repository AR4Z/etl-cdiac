<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\BaseFactStructureContract;

interface FactRepositoryContract extends BaseFactStructureContract
{
    /**
     * @param array $data
     * @return bool
     */
    public function insertDataEncode(array $data = []) : bool;
}