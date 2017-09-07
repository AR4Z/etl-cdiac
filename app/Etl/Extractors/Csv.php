<?php

namespace App\Etl\Extractors;

use App\Etl\EtlConfig;
use Illuminate\Support\Facades\Config;
use Maatwebsite\Excel\Facades\Excel;


class Csv extends ExtractorBase implements ExtractorInterface
{
  /**
   * $method is the data type incoming
   */
    private $method = 'Csv';

    public $etlConfig = null;

    public $fileName = null;

    public $extractTypeObject = null;

    public $extractType = null;

    public  $truncateTemporal = true;

    public $flagStationSk = false;

    public $flagDateSk = false;

    public $flagTimeSk = false;


    /**
     * Csv constructor.
     * @param $etlConfig
     * @return $this|mixed
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;
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


    public function run()
    {
        # Truncar la tabla de trabajo
        $this->configureSpaceWork();

        #Leer e insertar datos en base de datos
        $this->loadFile();

        # Ingresar la llave subrrogada de la estacion
        if (!$this->flagStationSk){
            $this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());
        }

        # Ejecutar el proceso de confianza y soporte de los datos
        //$trustProcess = $this->trustProcess();
    }

    private function loadFile()
    {
        Excel::load(storage_path().'/app/public/'.$this->fileName, function($reader) {

            $inputVariables = $reader->all()->getHeading();
            $variablesName = $this->getVariablesName();
            $variablesNameExcel = array_keys($variablesName);
            foreach ($reader->get() as $values){
                $val = [];
                $values->toArray();
                foreach ($inputVariables as $inputVariable){
                    if (in_array($inputVariable,$variablesNameExcel)){
                        $val[$variablesName[$inputVariable]] = $values[$inputVariable];
                    }
                }
                ($this->etlConfig->getRepositorySpaceWork())::create($val);
            }
        });
    }

    private function getVariablesName()
    {
        $arr = [];
        $configCsv = (object)Config::get('etl')['csv_keys'][$this->etlConfig->getStation()->typeStation->etl_method];
        foreach ($configCsv as $key => $value){$arr[$key] = $value['local_name'];}
        foreach ($this->etlConfig->getVarForFilter() as $value){$arr[$value->excel_name] = $value->local_name ;}
        return $arr;
    }
}
