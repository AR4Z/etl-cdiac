<?php

namespace App\Etl\Extractors;

use App\Etl\EtlConfig;
use function Couchbase\defaultDecoder;

class Database extends ExtractorBase implements ExtractorInterface
{
  /**
   * $method is the data type incoming
   */

    public $method = 'Database';

    public $etlConfig = null;

    public $extractTypeObject = null;

    public $extractType = null;

    public  $truncateTemporal = true;

    /**
     * @param $etlConfig
     * @return mixed|void
     */
    public function setOptions(EtlConfig $etlConfig)
    {
        $this->etlConfig = $etlConfig;
        return $this;
    }

    /**
     * @return $this
     * @internal param EtlConfig $etlConfig
     */
    public function run()
    {
        # Truncar la tabla de trabajo
        $this->configureSpaceWork();

        # Configurar las consultas para la extraccion de los datos
        ($this->etlConfig->getKeys())->config(
            $this->etlConfig->getTypeProcess(),
            $this->etlConfig->getStation()->typeStation->etl_method,
            $this->method,
            $this->extractType
        );

        # Crear el objeto de extraccion /ExtracType (este posee configuraciones diferentes para local y externa)
        $this->extractTypeObject = $this->createExtractType($this->extractType,$this->etlConfig);

        # Insertar datos en el espacio de trabajo
        $this->insertAllDataInTemporal(
            ($this->extractTypeObject)->extractData(
                $this->etlConfig->getkeys(),
                $this->etlConfig->getInitialDate(),
                $this->etlConfig->getInitialTime(),
                $this->etlConfig->getFinalDate(),
                $this->etlConfig->getFinalTime(),
                10000
            )
        );

        # Ingresar la llave subrrogada de la estacion
        if (($this->extractTypeObject)->flagStationSk){$this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());}
        # Ingresar la llave subrrogada de la fecha
        if (($this->extractTypeObject)->flagDateSk){$this->updateDateSk($this->etlConfig->getRepositorySpaceWork());}
        # Ingresar la llave subrrogada de la tiempo
        if (($this->extractTypeObject)->flagTimeSk){$this->updateTimeSk($this->etlConfig->getRepositorySpaceWork());}

        # Ejecutar el proceso de confianza y soporte de los datos
        $trustProccess = $this->trustProcess();

        return $this;
    }

    /**
     * @param $data
     * @return bool
     * @internal param $repository
     */
    private function insertAllDataInTemporal($data)
    {
        $this->insertData('temporary_work',$this->etlConfig->getTableSpaceWork(),($this->extractTypeObject)->columns, $data);
        return true;
    }






}
