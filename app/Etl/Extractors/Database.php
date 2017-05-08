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

    private $select = 'fecha, hora, ';

    private  $columns = array('fecha','hora');

    public $etlConfig = null;

    /**
     * @param $etlConfig
     * @return mixed|void
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        // Configuration
        $this->etlConfig = $etlConfig;
        $this->setSelect($etlConfig->getVarForFilter(), 'name_database', 'name_locale');

        return $this;

    }

    /**
     * @return $this
     * @internal param EtlConfig $etlConfig
     */
    public function extract()
    {
        $this->settingConnection($this->etlConfig->getNet());
        $this->insertAllDataInTemporal($this->selectServerAcquisition());
        $this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());

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
     * @param $colOrigin
     * @param $colDestination
     * @return $this
     */
    public function setSelect($variables, $colOrigin, $colDestination)
    {
        $temporalSelect = '';

        foreach ($variables as $variable){
            $temporalSelect .= $variable->$colOrigin .' as '. $variable->$colDestination.', ';
            array_push($this->columns,$variable->$colDestination);
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
            'external_connection',
            $this->etlConfig->getStation()->name_table,
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
    private function insertAllDataInTemporal($data){

        $this->truncateTemporalWork($this->etlConfig->getRepositorySpaceWork());

        $this->insertData('temporary_work',$this->etlConfig->getTableSpaceWork(),$this->columns, $data);

        $this->updateDateSk($this->etlConfig->getRepositorySpaceWork());
        $this->updateTimeSk($this->etlConfig->getRepositorySpaceWork());

        return true;
    }


}
