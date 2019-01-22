<?php

namespace App\Etl\Execution;

/**
 * context Strategy
 */
class EtlExecute
{
    /**
     * @var bool
     */
    private $sequence = false;

    /**
     * @var bool
     */
    private $debug = true;

    /**
     * @var ExecuteStrategy
     */
    private $executeStrategy;

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
        return $this->executeStrategy->execute(['sequence'=> $this->sequence,'debug'=> $this->debug]);
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