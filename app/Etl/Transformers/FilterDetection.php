<?php


namespace app\Etl\Transformers;


use App\Etl\EtlConfig;

class FilterDetection extends TransformBase implements TransformInterface
{

    private $method = 'Detection';

    private $etlConfig = null;

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;

        return $this;
    }

    /**
     *
     */
    public function transform()
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