<?php

namespace App\Repositories\Config;

use App\Repositories\AppBaseRepository;
use App\Repositories\RepositoriesContract;
use Illuminate\Container\Container;
use App\Entities\Auditory\Analysis;

class AnalysisRepository extends AppBaseRepository implements RepositoriesContract
{
    /**
     * RepositoriesContract constructor.
     * @param Container $container
     */
    public function __construct(Container $container)
    {
        $this->setContainer($container)->setModel(Analysis::class)->setRepositoryId('rinvex.repository.uniqueid');
    }

    /**
     * @param $connectionName
     * @return Analysis
     */
    public function getId($connectionName) : Analysis
    {
        return $this->where('id', $connectionName)->first();
    }

    /**
     * @param $connectionName
     * @return Analysis
     */
    public function getInitialRange($connectionName) : Analysis
    {
        return $this->where('initial_range', $connectionName)->first();
    }

    /**
     * @param $connectionName
     * @return Analysis
     */
    public function getEndRange($connectionName) : Analysis
    {
        return $this->where('end_range', $connectionName)->first();
    }

    /**
     * @param $connectionName
     * @return Analysis
     */
    public function getName($connectionName) : Analysis
    {
        return $this->where('name', $connectionName)->first();
    }

    /**
     * @param $connectionName
     * @return Analysis
     */
    public function getAnalysis($connectionName) : Analysis
    {
        return $this->where('analysis', $connectionName)->first();
    }
}
