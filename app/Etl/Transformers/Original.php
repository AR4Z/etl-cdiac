<?php

namespace App\Etl\Transformers;


use App\Etl\EtlConfig;


class Original extends TransformBase implements TransformInterface
{

    private $method = 'Original';

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        return $this;
    }

    public function run()
    {
        return $this;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }
}