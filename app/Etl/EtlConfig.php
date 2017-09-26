<?php

namespace App\Etl;

use App\Etl\Traits\RemoveAccents;
use Facades\App\Repositories\Administrator\NetRepository;
use Facades\App\Repositories\Administrator\ConnectionRepository;
use Facades\App\Repositories\Administrator\StationRepository;
use App\Etl\Config\PrimaryKeys;
use Config;
use Illuminate\Support\Facades\App;

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

  private $connection = null;

  private $varForFilter = null;
  /**
   * $station is dependence for: App\Repositories\Config\Station
   * $station indicates the station for work
   */
  private $station = null;

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

  private $initialTime = '00:00:00';

  private $finalTime = '23:59:59';

  private $trustColumns = [];

  private $incomingAmount = 0;

  private $keys = null;

  private $trustProcess = true;



    /**
     * EtlConfig constructor.
     * @param String $typeProcess
     * @param int $netId
     * @param int|null $connection
     * @param int $stationId
     * @param bool $sequence
     */

    function __construct(String $typeProcess, $netId,$connection, int $stationId,bool $sequence= false)
    {
        $this->setTypeProcess($typeProcess)
                ->setStation($stationId)
                ->setNet($netId)
                ->setConnection($connection)
                ->setVarForFilter($stationId)
                ->setSequence($sequence)
                ->config()
                ->setInitialDate($this->station->{$this->stateTable}->current_date)
                ->setInitialTime($this->station->{$this->stateTable}->current_time)
                ->setFinalDate(gmdate("Y-m-d",time()))
                ->setFinalTime('00:00:00');
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
    public function config()
    {
        $config = (object)Config::get('etl');

        $this->setKeys((array_key_exists('extraColumns',$config)) ? $config->extraColumns : false);

        if (!array_key_exists($this->typeProcess,$config)){
            //TODO exepcion por no existir el metodo buscado inserte el correcto
            dd('exepcion por no existir el metodo buscado inserte el correcto');
        }
        $config = (object)$config->{$this->typeProcess};

        if (!array_key_exists(str_replace (' ','_',$this->removeAccents($this->station->typeStation->etl_method)),$config)){
            //TODO exepcion por no existir el tipo de estacion buscado inserte el correcto
            dd('exepcion por no existir el tipo de estacion buscado inserte el correcto');
        }
        $config = (object)$config->{str_replace (' ','_',$this->removeAccents($this->station->typeStation->etl_method))};

        $this->setTableSpaceWork((array_key_exists('tableSpaceWork',$config)) ? $config->tableSpaceWork : false);
        $this->setTableDestination((array_key_exists('tableDestination',$config)) ? $config->tableDestination : false);
        $this->setRepositorySpaceWork((array_key_exists('repositorySpaceWork',$config)) ? $config->repositorySpaceWork : false);
        $this->setStateTable((array_key_exists('stateTable',$config)) ? $config->stateTable : false);
        $this->setRepositoryDestination((array_key_exists('repositoryDestination',$config)) ? $config->repositoryDestination : false);
        $this->setRepositoryExist((array_key_exists('repositoryExist',$config)) ? $config->repositoryExist : false);
        $this->setTableExist((array_key_exists('tableExist',$config)) ? $config->tableExist : false);
        $this->setTableTrust((array_key_exists('tableTrust',$config)) ? $config->tableTrust : false);
        $this->setTrustRepository((array_key_exists('trustRepository',$config)) ? $config->trustRepository : false);


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
     * @param $net
     * @return $this
     * @internal param int $netId
     */

  public function setNet($net)
  {
      $netId = (is_null($net)) ?  $this->station->owner_net_id : $net;
      $this->net = NetRepository::find($netId);
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
        if (is_null($initialDate)){
            //TODO
        }

        if (!is_string($initialDate)){
            $initialDate = $initialDate->toDateString();
        }

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
        if (is_null($initialTime)){
            //TODO
        }
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

    /**
     * @return int
     */
    public function getIncomingAmount(): int
    {
        return $this->incomingAmount;
    }

    /**
     * @param int $incomingAmount
     * @internal param int $incomingAmount
     * @return $this
     */
    public function setIncomingAmount(int $incomingAmount)
    {
        $this->incomingAmount = $incomingAmount;
        return $this;
    }

    /**
     * @return null
     */
    public function getConnection()
    {
        return $this->connection;
    }

    /**
     * @param null $connection
     * @return $this
     */
    public function setConnection($connection)
    {
        $connectionId = (is_null($connection)) ?  $this->net->connection_id : $connection;
        $this->connection = ConnectionRepository::find($connectionId);
        return $this;
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
     * @return $this
     * @internal param null $varForFilter
     */
    public function setVarForFilter($stationId)
    {
        $this->varForFilter = StationRepository::findVarForFilter($stationId);
        return $this;
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
     * @return $this
     */
    public function setTrustProcess(bool $trustProcess)
    {
        $this->trustProcess = $trustProcess;
        return $this;
    }

    /**
     * @param $keys
     * @return $this
     */
    public function setKeys($keys)
    {
        $this->keys = new PrimaryKeys($keys) ;
        return $this;
    }

    /**
     * @return null
     */
    public function getKeys()
    {
        return $this->keys;
    }

}
