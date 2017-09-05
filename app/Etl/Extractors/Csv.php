<?php

namespace App\Etl\Extractors;

use App\Etl\EtlConfig;
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
        Excel::load(storage_path().'/app/public/'.$this->fileName, function($reader) {

            foreach ($reader->get() as $values){
                dd($values->toArray());
            }

        });

        # Ingresar la llave subrrogada de la estacion
        /*if (!($this->extractTypeObject)->flagStationSk){
            $this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());
        }*/

        # Ejecutar el proceso de confianza y soporte de los datos
        //$trustProccess = $this->trustProcess();
    }
}
