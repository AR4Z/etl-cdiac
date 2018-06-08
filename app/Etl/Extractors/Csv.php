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

    public $truncateTemporal = true;

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

    /**
     * @return $this|mixed
     */
    public function run()
    {
        if ($this->truncateTemporal){
            # Truncar la tabla de trabajo
            $this->configureSpaceWork();

            #Leer e insertar datos en base de datos
            $this->loadFile();

            # Se elimina la ultima fecha para datos de aire que tiene hora incorrecta
            $this->deleteLastDate($this->etlConfig->getTableSpaceWork(),'24:00:00');
        }

        # Ingresar la llave subrrogada de la estacion
        if (!$this->flagStationSk){$this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());}

        # Ingresar la llave subrrogada de la fecha
        if (!$this->flagDateSk){$this->updateDateSk($this->etlConfig->getRepositorySpaceWork());}

        # Ingresar la llave subrrogada de la tiempo
        if (!$this->flagTimeSk){$this->updateTimeSk($this->etlConfig->getRepositorySpaceWork());}

        # Editar las fechas y horas iniciales y finales dependiendo de los registros engresados por archivo plano
        $this->configureDateTimes();

        # Ejecutar el proceso de confianza y soporte de los datos
        $trustProcess = $this->trustProcess();

        return $this;
    }

    /**
     *
     */
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

    /**
     * @return array
     */
    private function getVariablesName()
    {
        $arr = [];
        $configCsv = (object)Config::get('etl')['csv_keys'][$this->etlConfig->getStation()->typeStation->etl_method];
        foreach ($configCsv as $key => $value){$arr[$key] = $value['local_name'];}
        foreach ($this->etlConfig->getVarForFilter() as $value){$arr[$value->excel_name] = $value->local_name ;}
        return $arr;
    }

    /**
     *
     */
    private function configureDateTimes()
    {
        $repository = $this->etlConfig->getRepositorySpaceWork();
        $initVal = $this->getInitialDataInSpaceWork($repository);
        $finalVal = $this->getFinalDataInSpaceWork($repository);

        if (!is_null($initVal)){
            $this->etlConfig->setInitialDate(
                $this->calculateDateFromDateSk($initVal->date_sk)
            );
            $this->etlConfig->setInitialTime(
                $this->calculateTimeFromTimeSk($initVal->time_sk)
            );
        }
        if (!is_null($finalVal)){
            $this->etlConfig->setFinalDate(
                $this->calculateDateFromDateSk($finalVal->date_sk)
            );
            $this->etlConfig->setFinalTime(
                $this->calculateTimeFromTimeSk($finalVal->time_sk)
            );
        }
    }
}
