<?php

namespace App\Etl;

use App\Etl\Traits\RemoveAccents;
use Facades\App\Repositories\Config\StationRepository;
use Facades\App\Repositories\Config\ConnectionRepository;
use Config;

/**
 *
 */
class EtlConfig
{
    use RemoveAccents;
  /**
   * $typeProcess is option variable: 'Original' - 'Filter' - null
   */
  private $typeProcess = null;


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

  private $repositorySpaceWork = null;

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
                ->setVarForFilter($stationId)
                ->config();
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

    public function config()
    {
        $config = (object)Config::get(
                                    'etl'.$this->typeProcess.'.'
                                    .str_replace (
                                        ' ',
                                        '_',
                                        $this->removeAccents($this->station->type).''
                                    ));

        $this   ->setTableSpaceWork($config->tableSpaceWork)
                ->setTableDestination($config->tableDestination)
                ->setRepositorySpaceWork($config->repositorySpaceWork);

        return $this;

    }

    /**
     * @param $spaceWorkTable
     * @return $this
     */

  public function setTableSpaceWork($spaceWorkTable)
  {
    $this->tableSpaceWork = $spaceWorkTable;
    return $this;
  }

    /**
     * @param $destinationTable
     * @return $this
     */
  public function setTableDestination($destinationTable)
  {
      $this->tableDestination = $destinationTable;
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
     * @return $this
     */
    public function setVarForFilter($stationId)
    {
        $this->varForFilter = StationRepository::findVarForFilter($stationId);

        return $this;
    }

    /**
     * @return null
     */
    public function getRepositorySpaceWork()
    {
        return $this->repositorySpaceWork;
    }

    /**
     * @param null $repositorySpaceWork
     */
    public function setRepositorySpaceWork($repositorySpaceWork)
    {
        $this->repositorySpaceWork = $repositorySpaceWork;
    }

}
