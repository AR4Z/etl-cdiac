<?php

namespace App\Repositories\DataWareHouse;

use App\Repositories\BaseFactStructureRepository;

class BaseFactRepository extends BaseFactStructureRepository
{
    /**
     * @param array $data
     * @return bool
     */
    public function insertDataEncode(array $data = []) : bool
    {
        $localData =  array_chunk(json_decode(json_encode($data),true),5000,true);

        foreach ($localData as $localValue){ $this->queryBuilder()->insert($localValue);}

        return true;
    }
}