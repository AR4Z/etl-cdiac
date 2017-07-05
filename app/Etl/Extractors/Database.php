<?php

namespace App\Etl\Extractors;

use App\Etl\Database\DatabaseConfig;
use App\Etl\Traits\WorkDatabaseTrait;
use App\Etl\EtlConfig;
use Facades\App\Repositories\TemporaryWork\TemporalWeatherRepository;
use App\Etl\Traits\TrustTrait;
use PhpParser\Node\Stmt\Return_;


class Database extends ExtractorBase implements ExtractorInterface
{
    use DatabaseConfig,WorkDatabaseTrait,TrustTrait;

  /**
   * $method is the data type incoming
   */

    private $method = 'Database';

    private $select = null;

    private $keys = 'station_sk,date_sk,time_sk';

    private $keysCast = 'station_sk,date_sk,time_sk';

    private $columns = array('station_sk','date_sk','time_sk');

    public $etlConfig = null;

    public $extractType = 'Locale';

    public $extractConnection = 'data_warehouse';

    public $extractTable = null;

    public $colOrigin = 'local_name';

    public $colDestination = 'local_name';

    public $flagStationSk = true;

    public $flagDateSk = true;

    public $flagTimeSk = true;

    /**
     * @param $etlConfig
     * @return mixed|void
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        // Configuration
        $this->etlConfig = $etlConfig;
        $this->extractTable = $etlConfig->getTableDestination();
        $this->truncateTemporalWork($this->etlConfig->getRepositorySpaceWork());
        return $this;

    }

    /**
     * @return $this
     * @internal param EtlConfig $etlConfig
     */
    public function extract()
    {
        if ($this->extractType == 'External'){
            $this->settingConnection($this->etlConfig->getConnection());
            $this->extractConnection = 'external_connection';
            $this->extractTable = $this->setExtractRemoteTable();
            $this->colOrigin = 'database_field_name';
            $this->keys = 'fecha, hora';
            $this->keysCast = 'fecha as fecha, hora as time';
            $this->columns = array('date','time');
            $this->flagStationSk = false;
            $this->flagDateSk = false;
            $this->flagTimeSk = false;
        }

        $this->setSelect($this->etlConfig->getVarForFilter());
        $this->insertAllDataInTemporal($this->selectServerAcquisition());
        dd($this);
        if (!$this->flagStationSk){$this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());}

        // trust process
        $trust = $this->incomingCalculation(
                    $this->etlConfig->getTrustRepository(),
                    $this->etlConfig->getTableSpaceWork(),
                    $this->etlConfig->getTableTrust(),
                    $this->etlConfig->getVarForFilter()->toArray()
                );

        $this->etlConfig->setIncomingAmount($this->getIncomingAmount($this->etlConfig->getTableSpaceWork()));

        $this->etlConfig->setTrustColumns($trust);

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
     * @return $this
     */
    public function setSelect($variables)
    {
        $temporalSelect = $this->keysCast.',';

        foreach ($variables as $variable){
            $temporalSelect .= $variable->{$this->colOrigin} .' as '. $variable->{$this->colDestination}.', ';
            array_push($this->columns,$variable->{$this->colDestination});
        }
        $temporalSelect[strlen($temporalSelect)-2] = ' ';
        $this->select .= $temporalSelect;

        return $this;

    }

    /**
     * @param $connection
     * @return $this
     */
    public function settingConnection($connection)
    {
        $this->configExternalConnection($connection);
        return $this;
    }

    /**
     * @return mixed
     */
    private function selectServerAcquisition()
    {
        return $this->getData(
            $this->extractConnection,
            $this->extractTable,
            $this->keys,
            $this->select,
            $this->etlConfig->getInitialDate(),
            $this->etlConfig->getInitialTime(),
            $this->etlConfig->getFinalDate(),
            $this->etlConfig->getFinalTime(),
            50
        );
    }

    /**
     * @param $data
     * @return bool
     * @internal param $repository
     */
    private function insertAllDataInTemporal($data)
    {
        $this->insertData('temporary_work',$this->etlConfig->getTableSpaceWork(),$this->columns, $data);

        dd($this); //TODO

        if (!$this->flagDateSk){$this->updateDateSk($this->etlConfig->getRepositorySpaceWork());}
        if (!$this->flagTimeSk){$this->updateTimeSk($this->etlConfig->getRepositorySpaceWork());}


        return true;
    }

    private function setExtractRemoteTable()
    {
        $extractTable = $this->etlConfig->getStation()->table_db_name;

        if (is_null($extractTable)){
            //TODO excepcion por no hallar tabla de extracccion...
        }
        return $extractTable;
    }


}
