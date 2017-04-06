<?php


namespace App\Etl\Loaders;


use App\Etl\EtlConfig;
use Illuminate\Support\Facades\DB;

class Load extends LoadBase implements LoadInterface
{

    private $method = 'General';

    private  $etlConfig = null;

    private $select = 'estacion_sk,fecha_sk,tiempo_sk, ';

    /**
     * @param EtlConfig $etlConfig
     * @return mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;
        $this->setSelect($etlConfig->getVarForFilter(), 'name_locale', 'name_locale');
        return $this;
    }

    public function load()
    {
        $consult = $this->insertData();
        //dd($consult);
        return $this;
    }

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

    public function insertData()
    {
        $values = DB::connection('temporary_work')->table($this->etlConfig->getTableSpaceWork())->select(DB::raw($this->select))->get()->all();

        foreach ($values as $value){
            $dataSet = array();
            foreach ($value as $key => $val){
                $dataSet[$key] = $val;
            }
            DB::connection('data_warehouse')->table($this->etlConfig->getTableDestination())->insert([$dataSet]);
        }

        return $values;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @param string $method
     */
    public function setMethod(string $method)
    {
        $this->method = $method;
    }
}