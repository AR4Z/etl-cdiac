<?php

namespace App\Etl;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use Illuminate\Support\Arr;
use App\Etl\Traits\RemoveAccents;
use App\Repositories\RepositoryFactoryTrait;
use App\Entities\Administrator\{Connection, Net, Station };
use App\Repositories\DataWareHouse\{FactRepositoryContract, ReliabilityRepositoryContract};
use App\Repositories\TemporaryWork\{ExistRepositoryContract, TemporalRepositoryContract};
use Facades\App\Repositories\Administrator\{NetRepository, ConnectionRepository, StationRepository};
use App\Etl\Config\PrimaryKeys;
use Config;
use phpDocumentor\Reflection\Types\Null_;
use PhpParser\Node\Expr\Cast\Object_;

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
     * @var PrimaryKeys
     */
    public $keys = null;

    /**
     * @var array
     */
    public $config = null;

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
     * @var bool
     */
    public $calculateDateTime = true;

    /**
     * @var bool
     */
    public $sequence = true;

    /**
     * @var FactRepositoryContract
     */
    public $repositoryDestination = null;

    /**
     * @var TemporalRepositoryContract
     */
    public $repositorySpaceWork = null;

    /**
     * @var ExistRepositoryContract
     */
    public $repositoryExist = null;

    /**
     * @var TrustProcess
     */
    public $trustObject = null;

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
        $this->setTrustObject(new TrustProcess());

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
    public function config() : void
    {
        $this->config = Config::get('etl');
        $this->setKeys(Arr::get($this->config,'extraColumns',false));

        if (!Arr::has($this->config,$this->typeProcess)){
            //TODO exepcion por no existir el metodo buscado inserte el correcto
            dd('exepcion por no existir el metodo buscado inserte el correcto');
        }

        $typeProcessConfig = Arr::get($this->config,$this->typeProcess);
        $methodConfig = str_replace(' ','_',$this->removeAccents($this->station->typeStation->etl_method));

        if (!Arr::has($typeProcessConfig,$methodConfig)){
            //TODO exepcion por no existir el tipo de estacion buscado inserte el correcto
            dd('exepcion por no existir el tipo de estacion buscado inserte el correcto');
        }

        $this->setTableSpaceWork(Arr::get($typeProcessConfig,"$methodConfig.tableSpaceWork"));
        $this->setTableDestination(Arr::get($typeProcessConfig,"$methodConfig.tableDestination"));
        $this->setRepositorySpaceWork(Arr::get($typeProcessConfig,"$methodConfig.repositorySpaceWork"));
        $this->setStateTable(Arr::get($typeProcessConfig,"$methodConfig.stateTable"));
        $this->setRepositoryDestination(Arr::get($typeProcessConfig,"$methodConfig.repositoryDestination"));
        $this->setRepositoryExist(Arr::get($typeProcessConfig,"$methodConfig.repositoryExist"));
        $this->setTableExist(Arr::get($typeProcessConfig,"$methodConfig.tableExist"));
        $this->setTableTrust(Arr::get($typeProcessConfig,"$methodConfig.tableTrust"));
        $this->setTrustRepository(Arr::get($typeProcessConfig,"$methodConfig.trustRepository"));
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

    public function setTableSpaceWork(string $spaceWorkTable = null) : void
    {
        if (is_null($spaceWorkTable)){
            # TODO
            dd('Error: no se puede pasar un $spaceWorkTable en null');
        }

        $this->tableSpaceWork = $spaceWorkTable;
    }

    /**
     * @param $destinationTable
     */
    public function setTableDestination(string $destinationTable = null) : void
    {
        if (is_null($destinationTable)){
            # TODO
            dd('Error: no se puede pasar un $destinationTable en null');
        }

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
    public function setRepositorySpaceWork(string $repositorySpaceWork = null) : void
    {
        if (is_null($repositorySpaceWork)){
            # TODO
            dd('Error: no se puede pasar un $repositorySpaceWork en null');
        }

        $this->repositorySpaceWork = $this->factoryRepositories("App\\Repositories\\TemporaryWork\\".$repositorySpaceWork);
    }

    /**
     * @param bool|true $sequence
     */
    public function setSequence(bool $sequence)
    {
        $this->sequence = $sequence;
    }

    /**
     * @param string $stateTable
     */
    public function setStateTable(string $stateTable = null) : void
    {
        if (is_null($stateTable)){
            # TODO
            dd('Error: no se puede pasar un $stateTable en null');
        }

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
    public function setRepositoryDestination(string $repositoryDestination = null) : void
    {
        if (is_null($repositoryDestination)){
            # TODO
            dd('Error: no se puede pasar un $repositoryDestination en null');
        }

        $this->repositoryDestination = $this->factoryRepositories("App\\Repositories\\DataWareHouse\\".$repositoryDestination);
    }

    /**
     * @param string $repositoryExist
     */
    public function setRepositoryExist(string $repositoryExist = null) : void
    {
        if (is_null($repositoryExist)){
            # TODO
            dd('Error: no se puede pasar un $repositoryExist en null');
        }

        $this->repositoryExist = $this->factoryRepositories("App\\Repositories\\TemporaryWork\\".$repositoryExist);
    }

    /**
     * @param string $tableExist
     */
    public function setTableExist(string $tableExist = null) : void
    {
        if (is_null($tableExist)){
            # TODO
            dd('Error: no se puede pasar un $tableExist en null');
        }

        $this->tableExist = $tableExist;
    }

    /**
     * @param mixed $tableTrust
     */
    public function setTableTrust(string $tableTrust = null) : void
    {
        if (is_null($tableTrust)){
            # TODO
            dd('Error: no se puede pasar un $tableTrust en null');
        }

        $this->trustObject->setTable($tableTrust);
    }

    /**
     * @param string $trustRepository
     * @return void
     */
    public function setTrustRepository(string $trustRepository = null) : void
    {
        if (is_null($trustRepository)){
            # TODO
            dd('Error: no se puede pasar un $trustRepository en null');
        }

        $this->trustObject->setRepository(
            $this->factoryRepositories(
                "App\\Repositories\\DataWareHouse\\".$trustRepository
            )
        );
    }

    /**
     * @param int $connection
     */
    public function setConnection(int $connection = null) : void
    {
        $this->connection = ConnectionRepository::find((is_null($connection)) ?  $this->net->connection_id : $connection);
    }

    /**
     * @param $stationId
     */
    public function setVarForFilter(int $stationId) : void
    {
        $this->varForFilter = StationRepository::findVarForFilter($stationId);
    }

    /**
     * @param bool $trustProcess
     */
    public function setTrustProcess(bool $trustProcess) : void
    {
        $this->trustObject->setActive($trustProcess);
    }

    /**
     * @param $keys
     */
    public function setKeys($keys) : void
    {
        $this->keys = new PrimaryKeys($this->typeProcess,$this->station->typeStation->etl_method,$keys);
    }

    public function setConfig($config) : void
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

    /**
     * @param null $trustObject
     */
    public function setTrustObject($trustObject)
    {
        $this->trustObject = $trustObject;
    }
}
