<?php

namespace App\Etl;

use App\Entities\Administrator\{Connection, Net, Station };
use App\Etl\Traits\RemoveAccents;
use App\Repositories\RepositoryFactoryTrait;
use Facades\App\Repositories\Administrator\{NetRepository,ConnectionRepository,StationRepository};
use App\Etl\Config\PrimaryKeys;
use Config;
use Illuminate\Support\Collection;

class EtlConfig
{
    use RemoveAccents,RepositoryFactoryTrait;

    /**
     * $typeProcess is option variable: 'Original' - 'Filter' - null
     * @var string
     */
    public $typeProcess = null;

    /**
     * @var integer
     */
    public $processId = null;

    /**
     * @var EtlState
     */
    public $processState = null;

    /**
     * $net is dependence for: App\Repositories\Config\ConnectionRepository
     * $net indicates the station for work
     *  @var Net
     */
    public $net = null;

    /**
     * @var Connection
     */
    public $connection = null;

    /**
     * @var Collection
     */
    public $varForFilter = null;

    /**
     * $station is dependence for: App\Repositories\Config\Station
     * $station indicates the station for work
     * @var Station
     */
    public $station = null;

    /**
     * @var array
     */
    public $config = null;

    /**
     * @var string
     */
    public $tableTrust = null;

    /**
     * @var string
     */
    public $tableSpaceWork = null;

    /**
     * @var string
     */
    public $tableDestination = null;

    /**
     * @var string
     */
    public $tableExist = null;

    /**
     * @var string
     */
    public $stateTable = null;

    /**
     * @var string
     */
    public $initialDate = null;

    /**
     * @var string
     */
    public $finalDate = null;

    /**
     * @var string
     */
    public $initialTime = '00:00:00';

    /**
     * @var string
     */
    public $finalTime = '23:59:59';

    /**
     * @var array
     */
    public $trustColumns = [];

    /**
     * @var integer
     */
    public $incomingAmount = 0;

    /**
     * @var PrimaryKeys
     */
    public $keys = null;

    /**
     * @var bool
     */
    public $trustProcess = false;

    /**
     * @var bool
     */
    public $calculateDateTime = true;

    public $repositoryDestination = null;
    public $repositorySpaceWork = null;
    public $repositoryExist = null;
    public $trustRepository = null;
    public $sequence = null;

    /**
     * EtlConfig constructor.
     * @param String $typeProcess
     * @param int $netId
     * @param int|null $connection
     * @param int $stationId
     * @param bool $sequence
     */

    function __construct(String $typeProcess, $netId = null,$connection = null, int $stationId,bool $sequence= false)
    {
        $this->setProcessId(time());
        $this->setProcessState(new EtlState());

        $this->setTypeProcess($typeProcess);
        $this->setStation($stationId);
        $this->setNet($netId);
        $this->setConnection($connection);
        $this->setVarForFilter($stationId);

        $this->config();

        $this->setInitialDate((is_null($this->station->{$this->stateTable})) ? '1990-01-01' : $this->station->{$this->stateTable}->current_date);
        $this->setInitialTime((is_null($this->station->{$this->stateTable})) ? '00:00:00' : $this->station->{$this->stateTable}->current_time);

        $this->setFinalDate(gmdate("Y-m-d",time()));
        $this->setFinalTime('23:55:00');
    }

    /**
     * @param int $stationId
     * @return null
     */
    public function setStation(int $stationId)
    {
        $this->station= StationRepository::findRelationship($stationId);
    }

    /**
     *
     */
    public function config()
    {
        $config = (object)Config::get('etl');

        $this->config = $config;

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
    }


    /**
     * @param bool $debug
     */
    public function setDebug(bool $debug = false)
    {
        $this->processState->debug = $debug;
    }

    /**
     * @param $spaceWorkTable
     */

    public function setTableSpaceWork($spaceWorkTable)
    {
        $this->tableSpaceWork = $spaceWorkTable;
    }

    /**
     * @param $destinationTable
     */
    public function setTableDestination($destinationTable)
    {
        $this->tableDestination = $destinationTable;
    }


    /**
     * @param String $typeProcess

     */
    public function setTypeProcess(String $typeProcess)
    {
        $this->typeProcess  = $typeProcess;
    }

    /**
     * @param $net
     * @internal param int $netId
     */

    public function setNet($net)
    {
        $netId = (is_null($net)) ?  $this->station->net_id : $net;
        $this->net = NetRepository::find($netId);
    }

    /**
     * @param string $repositorySpaceWork
     */
    public function setRepositorySpaceWork(string $repositorySpaceWork)
    {
        $this->repositorySpaceWork = $this->factoryRepositories("App\\Repositories\\TemporaryWork\\".$repositorySpaceWork);
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
     * @param null $stateTable
     */
    public function setStateTable($stateTable)
    {
        $this->stateTable = $stateTable;
    }

    /**
     * @param $initialDate
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
    }

    /**
     * @param null $finalDate
     */
    public function setFinalDate($finalDate)
    {
        $this->finalDate = $finalDate;
    }

    /**
     * @param null $initialTime
     */
    public function setInitialTime($initialTime)
    {
        if (is_null($initialTime)){
            //TODO
        }
        $this->initialTime = $initialTime;
    }

    /**
     * @param null $finalTime
     */
    public function setFinalTime($finalTime)
    {
        $this->finalTime = $finalTime;
    }

    /**
     * @param string $repositoryDestination
     */
    public function setRepositoryDestination(string $repositoryDestination)
    {
        $this->repositoryDestination = $this->factoryRepositories("App\\Repositories\\DataWareHouse\\".$repositoryDestination);
    }

    /**
     * @param string $repositoryExist
     */
    public function setRepositoryExist(string $repositoryExist)
    {
        $this->repositoryExist = $this->factoryRepositories("App\\Repositories\\TemporaryWork\\".$repositoryExist);
    }

    /**
     * @param null $tableExist
     */
    public function setTableExist($tableExist)
    {
        $this->tableExist = $tableExist;
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
     * @param string $trustRepository
     * @return void
     */
    public function setTrustRepository(string $trustRepository)
    {
        $this->trustRepository = $this->factoryRepositories("App\\Repositories\\DataWareHouse\\".$trustRepository);
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
     * @param null $connection
     */
    public function setConnection($connection)
    {
        $connectionId = (is_null($connection)) ?  $this->net->connection_id : $connection;
        $this->connection = ConnectionRepository::find($connectionId);
    }

    /**
     * @param $stationId
     * @internal param null $varForFilter
     */
    public function setVarForFilter($stationId)
    {
        $this->varForFilter = StationRepository::findVarForFilter($stationId);
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
     */
    public function setTrustProcess(bool $trustProcess)
    {
        $this->trustProcess = $trustProcess;
    }

    /**
     * @param $keys
     */
    public function setKeys($keys)
    {
        $this->keys = new PrimaryKeys($this->typeProcess,$this->station->typeStation->etl_method,$keys) ;
    }

    public function setConfig($config)
    {
        $this->config = $config;
    }

    /**
     * @return bool
     */
    public function isCalculateDateTime(): bool
    {
        return $this->calculateDateTime;
    }

    /**
     * @param bool $calculateDateTime
     */
    public function setCalculateDateTime(bool $calculateDateTime)
    {
        $this->calculateDateTime = $calculateDateTime;
    }

    /**
     * @param int $processId
     */
    public function setProcessId(int $processId)
    {
        $this->processId = $processId;
    }

    /**
     * @param null $processState
     */
    public function setProcessState($processState)
    {
        $this->processState = $processState;
    }
}
