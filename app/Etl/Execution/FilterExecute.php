<?php

namespace App\Etl\Execution;

use App\Etl\Execution\Options\FilterOptions\FilterOptionContract;

/**
 * Concrete Strategy
 */
class FilterExecute extends ExecuteStrategy
{
    /**
     * @var bool
     */
    private $trustProcess = true;

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
    public function execute(array $executionParams = []) : array
    {
       $executionParams['trustProcess'] = $this->trustProcess;
       return $this->filterObject->runConfig('Filter',$executionParams);
    }

    /**
     * @return bool
     */
    public function isTrustProcess() : bool
    {
        return $this->trustProcess;
    }

    /**
     * @param bool $trustProcess
     */
    public function setTrustProcess(bool $trustProcess) : void
    {
        $this->trustProcess = $trustProcess;
    }
}