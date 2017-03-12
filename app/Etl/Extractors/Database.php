<?php

namespace App\Etl\Extractors;

use App\Etl\Database\DatabaseConfig;
use App\Etl\EtlConfig;

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


      private $select = 'fecha, hora, ';


    /**
     * @param $etlConfig
     * @return mixed|void
     */
    public function setOptions(EtlConfig $etlConfig)
    {

        $this->setSelect($etlConfig->getVarForFilter(), 'name_database', 'name_locale');
        $this->setWhere($etlConfig->getStation()->originalState);

        return $this;


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


    /**
     * @param $variables
     * @param $colOrigin
     * @param $colDestination
     */
    public function setSelect($variables, $colOrigin, $colDestination)
    {
        foreach ($variables as $variable){
            $this->select .= $variable->$colOrigin .' as '. $variable->$colDestination.' ';
        }

    }

    /**
     * @param $station
     */
    public function setWhere($station){
        dd($station->current_time);
    }


}
