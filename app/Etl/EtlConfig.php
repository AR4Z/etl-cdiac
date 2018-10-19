<?php

namespace App\Etl;

use App\Entities\Administrator\{Connection, Net, Station };
use App\Etl\Traits\RemoveAccents;
use Facades\App\Repositories\Administrator\{NetRepository,ConnectionRepository,StationRepository};
use App\Etl\Config\PrimaryKeys;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Collection;

class EtlConfig
{
    use RemoveAccents;

    /**
     * $typeProcess is option variable: 'Original' - 'Filter' - null
     * @var string
     */
    private $typeProcess = null;

    /**
     * @var integer
     */
    private $processId = null;

    /**
     * @var EtlState
     */
    public $processState = null;

    /**
     * $net is dependence for: App\Repositories\Config\ConnectionRepository
     * $net indicates the station for work
     *  @var Net
     */
    private $net = null;

    /**
     * @var Connection
     */
    private $connection = null;

    /**
     * @var Collection
     */
    private $varForFilter = null;

    /**
     * $station is dependence for: App\Repositories\Config\Station
     * $station indicates the station for work
     * @var Station
     */
    private $station = null;

    /**
     * @var array
     */
    private $config = null;

    /**
     * @var string
     */
    private $tableTrust = null;

    /**
     * @var string
     */
    public $tableSpaceWork = null;

    /**
     * @var string
     */
    private $tableDestination = null;

    /**
     * @var string
     */
    private $tableExist = null;

    /**
     * @var string
     */
    private $stateTable = null;

    /**
     * @var string
     */
    private $initialDate = null;

    /**
     * @var string
     */
    private $finalDate = null;

    /**
     * @var string
     */
    private $initialTime = '00:00:00';

    /**
     * @var string
     */
    private $finalTime = '23:59:59';

    /**
     * @var array
     */
    private $trustColumns = [];

    /**
     * @var integer
     */
    private $incomingAmount = 0;

    /**
     * @var PrimaryKeys
     */
    private $keys = null;

    /**
     * @var bool
     */
    private $trustProcess = false;

    /**
     * @var bool
     */
    private $calculateDateTime = true;

    public $repositoryDestination = null;
    public $repositorySpaceWork = null;
    public $repositoryExist = null;
    public $trustRepository = null;
    private $sequence = null;

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
     * @return string $this->tableSpaceWork
     */
    public function getTableSpaceWork() : string
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
     * @return string $this_typeProcess
     */
    public function getTypeProcess() : string
    {
        return $this->typeProcess;
    }


    /**
     * @return Net
     */
    public function getNet() : Net
    {
        return $this->net;
    }

    /**
     * @return Station
     */
    public function getStation() : Station
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
     */
    public function setRepositorySpaceWork($repositorySpaceWork)
    {
        $routeRepository = "App\\Repositories\\TemporaryWork\\".$repositorySpaceWork;
        $this->repositorySpaceWork = new $routeRepository;
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
     */
    public function setStateTable($stateTable)
    {
        $this->stateTable = $stateTable;
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
     */
    public function setFinalTime($finalTime)
    {
        $this->finalTime = $finalTime;
    }

    /**
     * @return null
     */
    public function getRepositoryDestination()
    {
        return $this->repositoryDestination;
    }

    /**
     * @param string $repositoryDestination
     */
    public function setRepositoryDestination(string $repositoryDestination)
    {
        $routeRepository = "App\\Repositories\\DataWareHouse\\".$repositoryDestination;
        $this->repositoryDestination = new $routeRepository;
    }

    /**
     * @return null
     */
    public function getRepositoryExist()
    {
        return $this->repositoryExist;
    }

    /**
     * @param string $repositoryExist
     */
    public function setRepositoryExist(string $repositoryExist)
    {
        $routeRepository = "App\\Repositories\\TemporaryWork\\".$repositoryExist;
        $this->repositoryExist = new $routeRepository;
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
     */
    public function setTableExist($tableExist)
    {
        $this->tableExist = $tableExist;
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
     * @param string $trustRepository
     * @return void
     */
    public function setTrustRepository(string $trustRepository)
    {
        $routeRepository = "App\\Repositories\\DataWareHouse\\".$trustRepository;
        $this->trustRepository = new $routeRepository;
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
     * @return Connection
     */
    public function getConnection() : Connection
    {
        return $this->connection;
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
     * @return null
     */
    public function getVarForFilter() : Collection
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

    /**
     * @return PrimaryKeys
     */
    public function getKeys() : PrimaryKeys
    {
        return $this->keys;
    }

    /**
     * @return mixed
     */
    public function getConfig()
    {
        return $this->config;
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
