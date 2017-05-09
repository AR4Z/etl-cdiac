<?php

namespace App\Etl\Extractors;

use App\Etl\Database\DatabaseConfig;
use App\Etl\Traits\WorkDatabaseTrait;
use App\Etl\EtlConfig;
use Facades\App\Repositories\TemporaryWork\TemporalWeatherRepository;
use App\Etl\Traits\TrustTrait;


class Database extends ExtractorBase implements ExtractorInterface
{
    use DatabaseConfig,WorkDatabaseTrait,TrustTrait;

  /**
   * $method is the data type incoming
   */

    private $method = 'Database';

    private $select = null;

    private $keys = 'estacion_sk,fecha_sk,tiempo_sk';

    private $columns = array('estacion_sk','fecha_sk','tiempo_sk');

    public $etlConfig = null;

    public $extractType = 'Locale';

    public $extractConnection = 'data_warehouse';

    public $extractTable = null;

    public $colOrigin = 'name_locale';

    public $colDestination = 'name_locale';

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
        $this->extractTable = 'original_'.$etlConfig->getTableDestination();

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
            $this->settingConnection($this->etlConfig->getNet());
            $this->extractConnection = 'external_connection';
            $this->extractTable = $this->etlConfig->getStation()->name_table;
            $this->colOrigin = 'name_database';
            $this->keys = 'fecha, hora';
            $this->columns = array('fecha','hora');
            $this->flagStationSk = false;
            $this->flagDateSk = false;
            $this->flagTimeSk = false;
        }

        $this->setSelect($this->etlConfig->getVarForFilter());
        $this->insertAllDataInTemporal($this->selectServerAcquisition());
        if (!$this->flagStationSk){$this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());}

        // trust process
        $trust = $this->incomingCalculation(
                    $this->etlConfig->getTrustRepository(),
                    $this->etlConfig->getTableSpaceWork(),
                    $this->etlConfig->getTableTrust(),
                    $this->etlConfig->getVarForFilter()->toArray()
                );

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
        $temporalSelect = $this->keys.',';

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
            10
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

        if (!$this->flagDateSk){$this->updateDateSk($this->etlConfig->getRepositorySpaceWork());}
        if (!$this->flagTimeSk){$this->updateTimeSk($this->etlConfig->getRepositorySpaceWork());}

        return true;
    }


}
