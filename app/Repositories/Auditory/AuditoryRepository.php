<?php

namespace App\Repositories\Auditory;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Connection;

/**
 *
 */
class AuditoryRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = AuditoryRepository::class;



    public function getId($connectionName)
    {
        return $this->where('id', $connectionName)->first();
    }

    public function getUserId($connectionName)
    {
        return $this->where('user_id', $connectionName)->first();
    }

    public function getStationId($connectionName)
    {
        return $this->where('station_id', $connectionName)->first();
    }

    public function getRiskId($connectionName)
    {
        return $this->where('risk_id', $connectionName)->first();
    }

    public function getCalculateRiskId($connectionName)
    {
        return $this->where('calculate_risk_id', $connectionName)->first();
    }

    public function getAnalysisId($connectionName)
    {
        return $this->where('analysis_id', $connectionName)->first();
    }

}
