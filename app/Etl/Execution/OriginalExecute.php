<?php

namespace App\Etl\Execution;

use App\Etl\Execution\Options\OriginalOptions\OriginalOptionContract;

/**
 * Concrete Strategy
 */
class OriginalExecute extends ExecuteStrategy
{

    /**
     * @var bool
     */
    private $trustProcess = false;

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
        $executionParams['trustProcess'] = $this->trustProcess;
        return $this->originalObject->runConfig('Original',$executionParams);
    }

    /**
     * @return bool
     */
    public function isTrustProcess(): bool
    {
        return $this->trustProcess;
    }

    /**
     * @param bool $trustProcess
     */
    public function setTrustProcess(bool $trustProcess)
    {
        $this->trustProcess = $trustProcess;
    }
}