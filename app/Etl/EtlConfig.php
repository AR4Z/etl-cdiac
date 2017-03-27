<?php

namespace App\Etl;

use Facades\App\Repositories\Config\StationRepository;
use Facades\App\Repositories\Config\ConnectionRepository;

/**
 *
 */

class EtlConfig
{
  /**
   * $typeProcess is option variable: 'Original' - 'Filter' - null
   *  1 - ( Original  - Clima )
   *  2 - ( Filter    - Clima )
   *  3 - ( Original  - Aire )
   *  4 - ( Filter    - Aire )
   */
  private $processId = null;

  /**
   * $typeProcess is option variable: 'Original' - 'Filter' - null
   */
  private $typeProcess = null;

  /**
   * $typeStation is option variable: 'Clima' - 'Aire' - null
   */
  private $typeStation = null;

  /**
   * $net is dependence for: App\Repositories\Config\ConnectionRepository
   * $net indicates the station for work
   */
  private $net = null;
  /**
   * $station is dependence for: App\Repositories\Config\Station
   * $station indicates the station for work
   */
  private $station = null;

  /**
   * $tableSpaceWork is optional: 'temporal_clima' - 'temporal_aire' - null
   * $tableSpaceWork indicates the temporal space work
   */
  private $tableSpaceWork = null;

  /**
   * $tableDestination is optional: 'fact_table' - 'fact_aire' - null
   * $tableDestination indicates the temporal space work
   */
  private $tableDestination = null;

  private $varForFilter = null;


    /**
     * EtlConfig constructor.
     * @param String $typeProcess
     * @param int $netId
     * @param int $stationId
     */

    function __construct(String $typeProcess, int $netId, int $stationId)
    {

        $this   ->setTypeProcess($typeProcess)
                ->setNet($netId)
                ->setStation($stationId)
                ->setTypeStation($this->station)
                ->setProcessId()
                ->setTableSpaceWork()
                ->setTableDestination()
                ->setVarForFilter($stationId);
        //dd($this);
    }

    /**
     * @param int $stationId
     * @return null
     */
    public function setStation(int $stationId)
    {
        $this->station= StationRepository::findRelationship($stationId);

        return $this;
    }


    /**
     * @return $this
     */
    public function setProcessId()
  {
    if ($this->typeProcess == 'Original' and $this->typeStation == 'Clima') {
      $this->processId = 1;
    }elseif ($this->typeProcess == 'Filter' and $this->typeStation == 'Clima') {
      $this->processId = 2;
    }elseif ($this->typeProcess == 'Original' and $this->typeStation == 'Aire') {
      $this->processId = 3;
    }elseif ($this->typeProcess == 'Filter' and $this->typeStation == 'Aire') {
      $this->processId = 4;
    }

    return $this;
  }

    /**
     * @return $this
     */

  public function setTableSpaceWork()
  {
    $this->tableSpaceWork = 'temporal_'.strtolower($this->typeStation);
    return $this;
  }

    /**
     * @return $this
     */
    public function setTableDestination()
  {
    if ($this->typeStation == 'Clima' ) {

      $this->tableDestination = 'fact_table';

    }elseif ($this->typeStation == 'Aire') {

      $this->tableDestination = 'fact_aire';
    }

    return $this;
  }

    /**
     * @param $station
     * @return $this
     */
    public function setTypeStation($station)
  {
    $this->typeStation  = $station->type;
    return $this;
  }

    /**
     * @param String $typeProcess
     * @return $this
     */
    public function setTypeProcess(String $typeProcess)
  {
    $this->typeProcess  = $typeProcess;
    return $this;
  }

    /**
     * @param int $netId
     * @return $this
     */
    public function setNet(int $netId)
  {
    $this->net = ConnectionRepository::find($netId);
    return $this;
  }


    /**
     * @return $this->processId
     */
    public function getProcessId()
  {
    return $this->processId;
  }

    /**
     * @return $this->tableSpaceWork
     */
    public function getTableSpaceWork()
  {
    return $this->tableSpaceWork;
  }

    /**
     * @return $this->tableDestination
     */

    public function getTableDestination()
  {
    return $this->tableDestination;
  }

    /**
     * @return $this_typeProcess
     */
    public function getTypeProcess()
  {
    return $this->typeProcess;
  }

    /**
     * @return $this->typeStation
     */
    public function getTypeStation()
  {
    return $this->typeStation;
  }

    /**
     * @return $this->net
     */
    public function getNet()
  {
    return $this->net;
  }

    /**
     * @return $this->station
     */
    public function getStation()
  {
    return $this->station;
  }

    /**
     * @return null
     */
    public function getVarForFilter()
    {
        return $this->varForFilter;
    }

    /**
     * @param $stationId
     * @internal param null $varForFilter
     */
    public function setVarForFilter($stationId)
    {
        $this->varForFilter = StationRepository::findVarForFilter($stationId);
    }

}
