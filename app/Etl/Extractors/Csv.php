<?php

namespace App\Etl\Extractors;

class Csv extends ExtractorBase implements ExtractorInterface
{
  /**
   * $method is the data type incoming
   */
  private $method = 'Csv';

    /**
     * Csv constructor.
     * @param $etlConfig
     */
    public function __construct($etlConfig)
    {

    }
    /**
     * @return mixed
     */
    public function getMethod()
    {
        return $this->method;
    }

    /**
     * @param mixed $method
     */
    public function setMethod($method)
    {
        $this->method = $method;
    }



}
