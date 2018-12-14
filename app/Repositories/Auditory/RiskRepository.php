<?php

namespace App\Repositories\Config;

use App\Entities\Auditory\Risk;
use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Connection;

/**
 *
 */
class RiskRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = Risk::class;



    public function getId($connectionName)
    {
        return $this->where('id', $connectionName)->first();
    }

    public function getRiskType($connectionName)
    {
        return $this->where('risk_type', $connectionName)->first();
    }

    public function getName($connectionName)
    {
        return $this->where('name', $connectionName)->first();
    }

    public function getDescription($connectionName)
    {
        return $this->where('description', $connectionName)->first();
    }

    public function getStationId($connectionName)
    {
        return $this->where('station_id', $connectionName)->first();
    }

    public function getVarId($connectionName)
    {
        return $this->where('var_id', $connectionName)->first();
    }

    public function getUserId($connectionName)
    {
        return $this->where('user_id', $connectionName)->first();
    }

    public function getMinimumRange($connectionName)
    {
        return $this->where('minimum_range', $connectionName)->first();
    }

    public function getMaximumRange($connectionName)
    {
        return $this->where('maximum_range', $connectionName)->first();
    }

    public function getNegativeRule($connectionName)
    {
        return $this->where('negative_rule', $connectionName)->first();
    }

    public function getNullRule($connectionName)
    {
        return $this->where('null_rule', $connectionName)->first();
    }

    public function getDiferenceRule($connectionName)
    {
        return $this->where('difference_rule', $connectionName)->first();
    }

    public function getOtherRule($connectionName)
    {
        return $this->where('other_rule', $connectionName)->first();
    }


    public function FindVarRange($station_id,$var_id)
    {

    }
}
