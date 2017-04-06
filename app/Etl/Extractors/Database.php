<?php

namespace App\Etl\Extractors;

use App\Etl\Database\DatabaseConfig;
use App\Etl\EtlConfig;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Facades\App\Repositories\TemporaryWork\TemporalWeatherRepository;


class Database extends ExtractorBase implements ExtractorInterface
{
    use DatabaseConfig;

  /**
   * $method is the data type incoming
   */

    private $method = 'Database';

    private $select = 'fecha, hora, ';

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

        //dd($etlConfig->getVarForFilter());
        //$this->initialDate = $etlConfig->

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
     * @return $this
     * @internal param EtlConfig $etlConfig
     */
    public function extract()
    {
        $this->settingConnection($this->etlConfig->getNet());
        $this->insertAllDataInTemporal($this->selectServerAcquisition());
        $this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());

        return $this;
    }

    /**
     * @return mixed
     * @internal param $etlConfig
     */
    private function selectServerAcquisition()
    {
        $total = DB::connection('external_connection')
            ->table($this->etlConfig->getStation()->name_table)
            ->select(DB::raw($this->select))
            ->whereBetween(
                DB::raw("concat_ws(' ',fecha, hora)"),
                [
                    Carbon::parse($this->etlConfig->getInitialDate().' '.$this->etlConfig->getInitialTime()),
                    Carbon::parse($this->etlConfig->getFinalDate().' '.$this->etlConfig->getFinalTime()),
                ]
            )
            ->orderby(DB::raw("concat_ws(' ',fecha, hora)"), 'asc')
            ->limit(100)//10000
            ->get()
            ->all();


        return $total;
    }

    /**
     * @param $data
     * @return bool
     * @internal param $repository
     */
    private function insertAllDataInTemporal($data){

        $this->truncateTemporalWork($this->etlConfig->getRepositorySpaceWork());

        foreach ($data as $can){
            $dataSet = array();
            foreach ($can as $key => $value){
                $dataSet[$key] = $value;
            }
            DB::connection('temporary_work')->table('temporal_weather')->insert($dataSet);
        }

        $this->updateDateSk($this->etlConfig->getRepositorySpaceWork());
        $this->updateTimeSk($this->etlConfig->getRepositorySpaceWork());

        return true;
    }


}
