<?php

namespace App\Etl\Execution;

use App\Etl\Execution\Options\FilterOptions\FilterOptionContract;

/**
 * Concrete Strategy
 */
class FilterExecute extends ExecuteStrategy
{
    /**
     * @var FilterOptionContract
     */
    private $filterObject;
    /**
     * FilterExecute constructor.
     * @param FilterOptionContract $filterObject
     */
    public function __construct(FilterOptionContract $filterObject)
    {
        $this->filterObject = $filterObject;
    }

    /**
     * @param array $executionParams
     * @return array
     */
    public function execute(array $executionParams = []): array
    {
        return $this->filterObject->runConfig('Filter',$executionParams);
    }
}