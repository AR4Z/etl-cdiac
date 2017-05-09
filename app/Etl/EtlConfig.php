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
     * $tableDestination is optional: 'fact_table' - 'fact_aire' - null
     * $tableDestination indicates the temporal space work
     */
  private $varForFilter = null;

    /**
   * $tableSpaceWork is optional: 'temporal_clima' - 'temporal_aire' - null
   * $tableSpaceWork indicates the temporal space work
   */


  private $tableTrust = null;

  private $tableSpaceWork = null;

  private $tableDestination = null;

  private $tableExist = null;

  private $repositoryDestination = null;

  private $repositorySpaceWork = null;

  private $repositoryExist = null;

  private $trustRepository = null;

  private $stateTable = null;

  private $sequence = null;

  private $initialDate = null;

  private $finalDate = null;

  private $initialTime = null;

  private $finalTime = null;

  private $trustColumns = [];

    /**
     * EtlConfig constructor.
     * @param String $typeProcess
     * @param int $netId
     * @param int $stationId
     * @param bool $sequence
     */

    function __construct(String $typeProcess, int $netId, int $stationId,bool $sequence= false)
    {
        $this   ->setTypeProcess($typeProcess)
                ->setNet($netId)
                ->setStation($stationId)
                ->setVarForFilter($stationId)
                ->setSequence($sequence)
                ->config()
                ->setInitialDate($this->station->{$this->stateTable}->current_date)
                ->setInitialTime($this->station->{$this->stateTable}->current_time)
                ->setFinalDate(gmdate("Y-m-d",time()))
                ->setFinalTime('00:00:00');

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
                                        $this->removeAccents($this->station->type)
                                    ));

        $this   ->setTableSpaceWork($config->tableSpaceWork)
                ->setTableDestination($config->tableDestination)
                ->setRepositorySpaceWork($config->repositorySpaceWork)
                ->setStateTable($config->stateTable)
                ->setRepositoryDestination($config->repositoryDestination)
                ->setRepositoryExist($config->repositoryExist)
                ->setTableExist($config->tableExist)
                ->setTableTrust($config->tableTrust)
                ->setTrustRepository($config->trustRepository);

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
     * @return $this|string ->tableDestination
     */

    public function getTableDestination(): string
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
     * @return $this
     */
    public function setRepositorySpaceWork($repositorySpaceWork)
    {
        $this->repositorySpaceWork = $repositorySpaceWork;

        return $this;
    }

    /**
     * @return null
     */
    public function getSequence()
    {
        return $this->sequence;
    }

    /**
     * @param bool|true $sequence
     * @return $this
     */
    public function setSequence(bool $sequence)
    {
        $this->sequence = $sequence;
        return $this;
    }

    /**
     * @return null
     */
    public function getStateTable()
    {
        return $this->stateTable;
    }

    /**
     * @param null $stateTable
     * @return $this
     */
    public function setStateTable($stateTable)
    {
        $this->stateTable = $stateTable;
        return $this;
    }

    /**
     * @return null
     */
    public function getInitialDate()
    {
        return $this->initialDate;
    }

    /**
     * @param null $initialDate
     * @return $this
     */
    public function setInitialDate($initialDate)
    {
        $this->initialDate = $initialDate;

        return $this;
    }

    /**
     * @return null
     */
    public function getFinalDate()
    {
        return $this->finalDate;
    }

    /**
     * @param null $finalDate
     * @return $this
     */
    public function setFinalDate($finalDate)
    {
        $this->finalDate = $finalDate;
        return $this;
    }

    /**
     * @return null
     */
    public function getInitialTime()
    {
        return $this->initialTime;
    }

    /**
     * @param null $initialTime
     * @return $this
     */
    public function setInitialTime($initialTime)
    {
        $this->initialTime = $initialTime;
        return $this;
    }

    /**
     * @return null
     */
    public function getFinalTime()
    {
        return $this->finalTime;
    }

    /**
     * @param null $finalTime
     * @return $this
     */
    public function setFinalTime($finalTime)
    {
        $this->finalTime = $finalTime;
        return $this;
    }

    /**
     * @return null
     */
    public function getRepositoryDestination()
    {
        return $this->repositoryDestination;
    }

    /**
     * @param null $repositoryDestination
     * @return $this
     */
    public function setRepositoryDestination($repositoryDestination)
    {
        $this->repositoryDestination = $repositoryDestination;
        return $this;
    }

    /**
     * @return null
     */
    public function getRepositoryExist()
    {
        return $this->repositoryExist;
    }

    /**
     * @param null $repositoryExist
     * @return $this
     */
    public function setRepositoryExist($repositoryExist)
    {
        $this->repositoryExist = $repositoryExist;
        return $this;
    }

    /**
     * @return null
     */
    public function getTableExist()
    {
        return $this->tableExist;
    }

    /**
     * @param null $tableExist
     * @return $this
     */
    public function setTableExist($tableExist)
    {
        $this->tableExist = $tableExist;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTableTrust()
    {
        return $this->tableTrust;
    }

    /**
     * @param mixed $tableTrust
     * @return $this
     */
    public function setTableTrust($tableTrust)
    {
        $this->tableTrust = $tableTrust;

        return $this;
    }

    /**
     * @return null
     */
    public function getTrustRepository()
    {
        return $this->trustRepository;
    }

    /**
     * @param $trustRepository
     * @return $this
     */
    public function setTrustRepository($trustRepository)
    {
        $this->trustRepository = $trustRepository;

        return $this;
    }

    /**
     * @return array
     */
    public function getTrustColumns(): array
    {
        return $this->trustColumns;
    }

    /**
     * @param array $trustColumns
     * @return $this
     */
    public function setTrustColumns(array $trustColumns)
    {
        $this->trustColumns = $trustColumns;

        return $this;
    }

}
