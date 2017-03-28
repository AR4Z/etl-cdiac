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



    /**
     * @param $etlConfig
     * @return mixed|void
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        // Configuration

        $this->setSelect($etlConfig->getVarForFilter(), 'name_database', 'name_locale');

        //execution

        $this->extract($etlConfig);

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
     * @param EtlConfig $etlConfig
     * @return $this
     */
    public function extract(EtlConfig $etlConfig)
    {

        $this->settingConnection($etlConfig->getNet());
        $this->insertAllDataInTemporal($this->selectServerAcquisition($etlConfig));

        return $this;
    }

    /**
     * @param $etlConfig
     * @return mixed
     */
    private function selectServerAcquisition($etlConfig){

        $total = DB::connection('external_connection')
            ->table($etlConfig->getStation()->name_table)
            ->select(DB::raw($this->select))
            ->whereBetween(
                DB::raw("concat_ws(' ',fecha, hora)"),
                [
                    $etlConfig->getStation()->originalState->full_date,
                    Carbon::today()
                ]
            )
            ->orderby(DB::raw("concat_ws(' ',fecha, hora)"), 'asc')
            ->limit(10000)
            ->get()
            ->all();

        return $total;
    }

    /**
     * @param $data
     * @return bool
     */
    private function insertAllDataInTemporal($data){

        foreach ($data as $can){
            $dataSet = array();
            foreach ($can as $key => $value){
                $dataSet[$key] = $value;
            }
            DB::connection('temporary_work')->table('temporal_weather')->insert($dataSet);
        }

        return true;
    }

}
