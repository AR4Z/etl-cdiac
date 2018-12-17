<?php

namespace App\Repositories\Config;

use App\Entities\Auditory\CalculateRisk;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Connection;

/**
 *
 */
class CalculateRiskRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = CalculateRisk::class;



    public function getId($connectionName)
    {
        return $this->where('id', $connectionName)->first();
    }

    public function getRiskId($connectionName)
    {
        return $this->where('risk_id', $connectionName)->first();
    }

    public function getImpact($connectionName)
    {
        return $this->where('impact', $connectionName)->first();
    }

    public function getProbability($connectionName)
    {
        return $this->where('probability', $connectionName)->first();
    }

    public function geVvulnerability($connectionName)
    {
        return $this->where('vulnerability', $connectionName)->first();
    }

}
