<?php

namespace App\Etl\Extractors;

use App\Etl\Database\DatabaseConfig;
/**
 *
 */
class Database extends ExtractorBase implements ExtractorInterface
{

  /**
   * $method is the data type incoming
   */
    private $method = 'Database';

    /**
     * $method is the data type incoming
     */
      private $variables = null;

    /**
     * $method is the data type incoming
     */
      private $connection = null;


    /**
     * Database constructor.
     * @param $etlConfig
     */
    function __construct($etlConfig)
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
