<?php

namespace App\Etl\Execution;

/**
 * context Strategy
 */
class EtlExecute
{
    /**
     * @var ExecuteStrategy
     */
    private $executeStrategy;

    /**
     * @var bool
     */
    private $sequence = false;

    /**
     * @var bool
     */
    private $trustProcess = false;

    /**
     * @var bool
     */
    private $debug = false;

    /**
     * EtlExecute constructor.
     * @param ExecuteStrategy $executeStrategy
     */
    public function __construct(ExecuteStrategy $executeStrategy)
    {
        $this->executeStrategy = $executeStrategy;
    }

    /**
     * @return array
     */
    public function execute() : array
    {
        return $this->executeStrategy->execute(['sequence'=> $this->sequence, 'trustProcess' => $this->trustProcess,'debug'=> $this->debug]);
    }

    /**
     * @return bool
     */
    public function isSequence(): bool
    {
        return $this->sequence;
    }
    /**
     * @param bool $sequence
     */
    public function setSequence(bool $sequence)
    {
        $this->sequence = $sequence;
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

    /**
     * @return bool
     */
    public function isDebug(): bool
    {
        return $this->debug;
    }

    /**
     * @param bool $debug
     */
    public function setDebug(bool $debug)
    {
        $this->debug = $debug;
    }
}