<?php

namespace App\Repositories\Config;

use Rinvex\Repository\Repositories\EloquentRepository;
use App\Entities\Config\Connection;

/**
 *
 */
class AnalysisRepository extends EloquentRepository
{

  protected $repositoryId = 'rinvex.repository.uniqueid';

  protected $model = AnalysisRepository::class;



    public function getId($connectionName)
    {
        return $this->where('id', $connectionName)->first();
    }

    public function getInitialRange($connectionName)
    {
        return $this->where('initial_range', $connectionName)->first();
    }

    public function getEndRange($connectionName)
    {
        return $this->where('end_range', $connectionName)->first();
    }

    public function getName($connectionName)
    {
        return $this->where('name', $connectionName)->first();
    }

    public function getAnalysis($connectionName)
    {
        return $this->where('analysis', $connectionName)->first();
    }
}
