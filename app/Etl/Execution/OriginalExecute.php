<?php

namespace App\Etl\Execution;

use App\Etl\Execution\Options\OriginalOptions\OriginalOptionContract;

/**
 * Concrete Strategy
 */
class OriginalExecute extends ExecuteStrategy
{
    /**
     * @var string
     */
    private $extractMethod = 'Database';
    /**
     * @var array
     */
    private $extractConfig = [];

    /**
     * @var string
     */
    private $runMethod = 'Asynchronous';

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
    /**
     * @return string
     */
    public function getRunMethod(): string
    {
        return $this->runMethod;
    }

    /**
     * @param string $runMethod
     */
    public function setRunMethod(string $runMethod)
    {
        $this->runMethod = $runMethod;
    }

    /**
     * @return array
     */
    public function getExtractConfig(): array
    {
        return $this->extractConfig;
    }

    /**
     * @param array $extractConfig
     */
    public function setExtractConfig(array $extractConfig)
    {
        $this->extractConfig = $extractConfig;
    }

    /**
     * @param string $variable
     * @param $value
     */
    public function addExtractConfigVariable(string $variable,$value)
    {
        $this->extractConfig[$variable] = $value;
    }

    /**
     * @return string
     */
    public function getExtractMethod(): string
    {
        return $this->extractMethod;
    }

    /**
     * @param string $extractMethod
     */
    public function setExtractMethod(string $extractMethod)
    {
        $this->extractMethod = $extractMethod;
    }
}