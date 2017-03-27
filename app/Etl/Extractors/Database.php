<?php

namespace App\Etl\Extractors;

use App\Etl\Database\DatabaseConfig;
use App\Etl\EtlConfig;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Facades\App\Repositories\TemporaryWork\TemporalWeatherRepository;

/**
 *
 */
class Database extends ExtractorBase implements ExtractorInterface
{
    use DatabaseConfig;

  /**
   * $method is the data type incoming
   */
    private $method = 'Database';

    /**
     * $method is the data type incoming
     */
      private $variables = null;

    /**
     * $method is the data type incoming
     */
      private $connection = null;


      private $select = 'fecha, hora, ';


    /**
     * @param $etlConfig
     * @return mixed|void
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->setSelect($etlConfig->getVarForFilter(), 'name_database', 'name_locale');
        $this->setWhere($etlConfig->getStation()->originalState);

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
     * @param $station
     */
    public function setWhere($station){
        //dd($station->current_time);
    }

    public function settingConnection($connection)
    {

        $this->configExternalConnection($connection);
        return $this;
    }



    public function extract(EtlConfig $etlConfig)
    {
        //dd($this->select);
        //dd($etlConfig->getStation()->originalState->full_date,Carbon::today());

        $this->settingConnection($etlConfig->getNet());

        $cantidad = DB::connection('external_connection')
                        ->table($etlConfig->getStation()->name_table)
                        ->select(DB::raw($this->select))
                        ->whereBetween(
                            DB::raw("concat_ws(' ',fecha, hora)"),
                            [
                                $etlConfig->getStation()->originalState->full_date,
                                Carbon::today()
                            ]
                        )
                        ->orderby('fecha','hora')
                        ->chunk(
                            1000,
                            function ($data){

                                TemporalWeatherRepository::create([$data]);
                            }
                        );
        dd("termine");

        return $this;
    }

}
