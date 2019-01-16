<?php

namespace App\Etl\Execution;

use App\Etl\Execution\Options\OriginalOptions\OriginalOptionContract;

/**
 * Concrete Strategy
 */
class OriginalExecute extends ExecuteStrategy
{
    /**
     * @var OriginalOptionContract
     */
    private $originalObject;

    /**
     * OriginalExecute constructor.
     * @param OriginalOptionContract $originalObject
     */
    public function __construct(OriginalOptionContract $originalObject)
    {
        $this->originalObject = $originalObject;
    }

    /**
     * @param array $executionParams
     * @return array
     */
    public function execute(array $executionParams = []): array
    {
        return $this->originalObject->runConfig('Original',$executionParams);
    }
}