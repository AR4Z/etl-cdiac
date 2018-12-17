<?php

namespace App\Repositories\Config;

use App\Entities\Auditory\RiskType;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Connection;

/**
 *
 */
class RiskTypeRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = RiskType::class;



    public function getId($connectionName)
    {
        return $this->where('id', $connectionName)->first();
    }

    public function getName($connectionName)
    {
        return $this->where('name', $connectionName)->first();
    }

    public function getDescription($connectionName)
    {
        return $this->where('description', $connectionName)->first();
    }

    public function getDataQualitys($connectionName)
    {
        return $this->where('data_quality', $connectionName)->first();
    }

}
