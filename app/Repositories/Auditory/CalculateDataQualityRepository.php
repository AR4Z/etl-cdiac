<?php

namespace App\Repositories\Config;

use App\Entities\Auditory\CalculateDataQuality;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Connection;

/**
 *
 */
class CalculateDataQualityRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = CalculateDataQuality::class;



    public function getId($connectionName)
    {
        return $this->where('id', $connectionName)->first();
    }

    public function getDataQualityId($connectionName)
    {
        return $this->where('data_quality_id', $connectionName)->first();
    }

    public function getRisk1($connectionName)
    {
        return $this->where('risk1', $connectionName)->first();
    }

    public function getRisk2($connectionName)
    {
        return $this->where('risk2', $connectionName)->first();
    }

    public function getRisk3($connectionName)
    {
        return $this->where('risk3', $connectionName)->first();
    }

    public function getRisk4($connectionName)
    {
        return $this->where('risk4', $connectionName)->first();
    }

    public function getRisk5($connectionName)
    {
        return $this->where('risk5', $connectionName)->first();
    }

    public function getVulnerability($connectionName)
    {
        return $this->where('vulnerability', $connectionName)->first();
    }
}
