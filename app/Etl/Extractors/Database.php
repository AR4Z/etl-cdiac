<?php

namespace App\Etl\Extractors;

use App\Etl\Database\DatabaseConfig;
use App\Etl\Traits\WorkDatabaseTrait;
use App\Etl\EtlConfig;
use Carbon\Carbon;
use Facades\App\Repositories\TemporaryWork\TemporalWeatherRepository;
use App\Etl\Traits\TrustTrait;
use PhpParser\Node\Stmt\Return_;


class Database extends ExtractorBase implements ExtractorInterface
{
    use DatabaseConfig,WorkDatabaseTrait,TrustTrait;

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
        if ($this->truncateTemporal){$this->truncateTemporalWork($this->etlConfig->getRepositorySpaceWork());}

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
                50
            )
        );

        # Ingresar la llave subrrogada de la estacion
        if (!($this->extractTypeObject)->flagStationSk){
            $this->updateStationSk($this->etlConfig->getStation(),$this->etlConfig->getRepositorySpaceWork());
        }
        # Ejecutar el proceso de confianza y soporte de los datos
        $this->trustProcess();

        return $this;
    }

    /**
     *
     */
    private function trustProcess(){
        # Calcular los datos entrantes para el preceso de confianza
        $trust = ($this->etlConfig->isTrustProcess())? $this->incomingCalculation($this->etlConfig->getTrustRepository(),$this->etlConfig->getTableSpaceWork(), $this->etlConfig->getTableTrust(), $this->etlConfig->getVarForFilter()->toArray()) : false;

        # Actualizar el estado del proceso de confianza
        $this->etlConfig->setTrustColumns($trust);

        # Calcular la Cantidad de datos entrante
        $this->etlConfig->setIncomingAmount(
            $this->getIncomingAmount(
                $this->etlConfig->getTableSpaceWork()
            )
        );
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
