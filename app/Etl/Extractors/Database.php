<?php

namespace App\Etl\Extractors;

use App\Etl\Database\DatabaseConfig;
use App\Etl\EtlConfig;


class Database extends ExtractorBase implements ExtractorInterface
{
    use DatabaseConfig;

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

        # Crear el objeto de extraccion /ExtracType
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
        if (!($this->extractTypeObject)->flagStationSk){
            $this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());
        }
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

        if (!($this->extractTypeObject)->flagDateSk){$this->updateDateSk($this->etlConfig->getRepositorySpaceWork());}
        if (!($this->extractTypeObject)->flagTimeSk){$this->updateTimeSk($this->etlConfig->getRepositorySpaceWork());}

        return true;
    }


    /**
     * @param $extractType
     * @param $etlConfig
     * @return mixed|object
     */
    private function createExtractType($extractType,$etlConfig)
    {
        if (! class_exists($extractType)) {
            if (isset($aliases['ExtractType'][$extractType])) {
                $extractType = $aliases['ExtractType'][$extractType];
            }
            $extractType = __NAMESPACE__ . '\\' . ucwords('ExtractType') . '\\' . $extractType;
        }
        return new $extractType($etlConfig);
    }



}
